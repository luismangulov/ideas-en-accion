<?php

namespace app\controllers;

use Yii;
use app\models\Registrar;
use app\models\Estudiante;
use app\models\Encuesta;
use app\models\Institucion;
use app\models\Ubigeo;
use app\models\Usuario;
use app\models\Participante;
use app\models\ParticipanteSearch;
use app\models\Etapa;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use SoapClient;

/**
 * ParticipanteController implements the CRUD actions for Participante model.
 */
class RegistrarController extends Controller {

    public function behaviors() {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all Participante models.
     * @return mixed
     */
    public function actionIndex() {
        $this->layout = 'registrar';
        $registrar = new Registrar;

        if (\Yii::$app->user->isGuest) {
            return $this->redirect(['/site/index']);
        }

        $usuario = Usuario::findIdentity(\Yii::$app->user->id);

        if ($usuario->status_registro == "2") {
            return $this->redirect(['/panel/ideas-accion']);
        }

        $etapa = Etapa::find()->where('estado=1')->one();

        if ($etapa->etapa != "1" && $usuario->status_registro == "1") {
            Yii::$app->session->setFlash('mensajeerror', 'La etapa de inscripción ha terminado');
            
            return $this->redirect(['site/index']);
        }


        $userIdString = $usuario->userId . "";
        //echo $userIdString.strlen ($userIdString);
        $userIdStringtmp = "";
        for ($i = 0; $i < strlen($userIdString); $i++) {
            $userIdStringtmp = $userIdStringtmp . $userIdString[$i] . "a";
        }


        $parametros = array(); //parametros de la llamada
        $parametros['token'] = base64_encode($userIdStringtmp);
        $parametros['usuario_externo'] = Yii::$app->params["usuarioWS"];
        $parametros['clave_externo'] = Yii::$app->params["claveWS"];
        $servicio = Yii::$app->params["urlWS"]; //url del servicio

        $opts2 = array(
            'ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => false
        ));

        $context2 = stream_context_create($opts2);
        $client = new SoapClient($servicio, array('stream_context' => $context2, 'soap_version' => SOAP_1_2));
        $result2 = $client->loginUserUID($parametros); //llamamos al métdo que nos interesa con los parámetrosF

        $connectionx = Yii::$app->db;
        $commandx = $connectionx->createCommand("SELECT * FROM institucion WHERE codigo_modular='" . ($result2->return->codModularIE) . "'");
        $rowx = $commandx->queryAll();

        $institucion_id = "";
        /* print_r($rowx);
          exit; */
        if (!empty($rowx)) {
            $institucion_id = $rowx[0]["id"];
        } else {
            $connectionx = Yii::$app->dbperueduca;
            $commandx = $connectionx->createCommand("SELECT * FROM bdpadron.padron WHERE ges_dep IN ('A1','A2','A3','A4') AND (niv_mod='F0' or niv_mod='D1' or niv_mod='D2') and estado='1' AND cod_mod='" . $result2->return->codModularIE . "'");
            $rowxie = $commandx->queryAll();
            //echo "SELECT * FROM bdpadron.padron WHERE ges_dep IN ('A1','A2','A3','A4') AND (niv_mod='F0' or niv_mod='D1' or niv_mod='D2') and estado='1' AND cod_mod='" . $result2->return->codModularIE . "'";
//print_r($rowxie);exit;
            if (!empty($rowxie)) {
                $institucion = new Institucion;
                $institucion->denominacion = $rowxie[0]["cen_edu"];
                $institucion->ubigeo_id = $rowxie[0]["codgeo"];
                $institucion->codigo_modular = $rowxie[0]["cod_mod"];
                $institucion->latitud = $rowxie[0]["nlat_ie"];
                $institucion->longitud = $rowxie[0]["nlong_ie"];
                $institucion->estado = 1;
                $institucion->save();
                $institucion_id = $institucion->id;
            } else {
                Yii::$app->session->setFlash('mensajeerror', 'El usuario no pertenece a una institución educativa focalizada');
                return $this->redirect(['site/index']);
            }
        }

        $estudiante = Estudiante::find()->where('id=:id', [':id' => $usuario->estudiante_id])->one();
        $estudiante->institucion_id = $institucion_id;

        //print_r($estudiante); exit;
        $estudiante->update();

//return $this->refresh();
        $institucion = Institucion::find()->where('id=:id', [':id' => $estudiante->institucion_id])->one();
        $ubigeo = Ubigeo::find()->where('district_id=:district_id', [':district_id' => $institucion->ubigeo_id])->one();
        $_SESSION["ubigeo"] = $ubigeo;
        $_SESSION["institucion"] = $institucion;



        if ($registrar->load(Yii::$app->request->post()) && $registrar->validate()) {
            if ($_SESSION["rol"] == "docente") {
                if ($registrar->grado != "6") {

                    exit;
                }
            } else if ($_SESSION["rol"] == "estudiante") {
                if ($registrar->grado == "6") {
                    echo "aqui";
                    exit;
                }
            }

            $fecha_nacimiento = str_replace("/", "-", $registrar->fecha_nac);
            $registrar->foto = UploadedFile::getInstance($registrar, 'foto');
            //$estudiante = new Estudiante;
            // echo $usuario->estudiante_id;
            if ($registrar->foto) {
                print_r($registrar->foto);
                /* exit; */

                if (!empty($registrar->foto->tempName)) {
                    $exif = exif_imagetype($registrar->foto->tempName);


                    $types = array(
                        2 => "JPEG",
                        3 => "PNG"
                    );

                    if (array_key_exists($exif, $types)) {
                        //  echo "Image type is: " . $types[$exif];
                    } else {
                        //echo "Not a valid image type";
                        Yii::$app->session->setFlash('error_file');
                        return $this->render('index', ['registrar' => $registrar]);
                    }

                    if ($registrar->foto->size / 1024 / 1024 > 1) {
                        Yii::$app->session->setFlash('error_file_size');
                        return $this->render('index', ['registrar' => $registrar]);
                    }
                } else {
                    Yii::$app->session->setFlash('error_file');
                    return $this->render('index', ['registrar' => $registrar]);
                }
            }

            $estudiante = Estudiante::find()->where('id=:id', [':id' => $usuario->estudiante_id])->one();
            // $usuario.getEstudiante();
            //$estudiante->sexo = $registrar->sexo;
            //$estudiante->fecha_nac = date("Y-m-d", strtotime($fecha_nacimiento));

            $estudiante->celular = $registrar->celular;
            //$estudiante->institucion_id = $registrar->institucion;
            $estudiante->grado = $registrar->grado;
            $estudiante->save();



            $usuario->fecha_actualizacion = date("Y-m-d H:i:s");

            //$usuario->estudiante_id = $estudiante->id;
            $usuario->save();

            /*
              $subject="Bienvenido a la plataforma de ideas en acción";
              $content="¡Bienvenido a ideas en acción!<br><br>
              Ahora podrás ingresar a tu propia cuenta en la plataforma con estos datos:
              <br><br>
              <b>Usuario:</b> $usuario->username <br>
              <b>Contraseña:</b> $registrar->password<br><br>
              <br>
              Haz clic en este <a href='http://intranet.ideasenaccion.pe/site/login'>link</a> para poder ingresar a la plataforma.
              ";
              Yii::$app->mail->compose('@app/mail/layouts/html',['content'=>$content])
              ->setFrom('info2@ideasenaccion.pe')
              ->setTo($registrar->email)
              ->setSubject($subject)
              ->send();
             */

            if ($registrar->foto) {
                $registrar->foto->saveAs('foto_personal/' . $usuario->id . '.' . $registrar->foto->extension);
                $usuario->avatar = $usuario->id . '.' . $registrar->foto->extension;
            } else {
                $usuario->avatar = "no_disponible.jpg";
            }
            $usuario->status_registro = "2";
            $usuario->save();
            Yii::$app->session->setFlash('registrar');



//return $this->refresh();
//return $this->refresh();
            //return $this->redirect(['site/login']);
            return $this->redirect(['panel/ideas-accion']);
//}
        }

        return $this->render('index', ['registrar' => $registrar]);
    }

    public function actionValidardni() {
        if (isset($_POST['dni'])) {
            $dni = $_POST['dni'];
            $estudiante = Estudiante::find()->where('dni=:dni', [':dni' => $dni])->one();
            if ($estudiante) {
                echo 1;
            } else {
                echo 0;
            }
        } else {
            $this->redirect(['registrar/index']);
        }
    }

    public function actionValidaremail() {
        if (isset($_POST['email'])) {
            $email = $_POST['email'];
            $estudiante = Estudiante::find()->where('email=:email', [':email' => $email])->one();
            if ($estudiante) {
                echo 1;
            } else {
                echo 0;
            }
        } else {
            $this->redirect(['registrar/index']);
        }
    }

}
