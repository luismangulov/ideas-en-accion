<?php

namespace app\models;

use Yii;
use yii\web\IdentityInterface;
use SoapClient;

/**
 * This is the model class for table "usuario".
 *
 * @property integer $id
 * @property string $username
 * @property string $password
 * @property integer $status
 * @property string $status_registro
 * @property integer $auth
 * @property string $verification_code
 * @property integer $estudiante_id
 * @property integer $userId
 *
 * @property AuthAssignment[] $authAssignments
 * @property AuthItem[] $itemNames
 * @property Estudiante $estudiante
 */
class Usuario extends \yii\db\ActiveRecord implements IdentityInterface {

    /**
     * @inheritdoc
     */
    public $auth_key;

    public static function tableName() {
        return 'usuario';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            //[['password', 'status'], 'required'],
            [['status', 'auth', 'estudiante_id'], 'integer'],
            [['userId'], 'integer'],
            [['status_registro'], 'string', 'max' => 1],
            [['username', 'password', 'status_registro'], 'string', 'max' => 100],
            [['verification_code'], 'string', 'max' => 250],
            [['username'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'username' => 'Username',
            'password' => 'Password',
            'status' => 'Status',
            'auth' => 'Auth',
            'verification_code' => 'Verification Code',
            'estudiante_id' => 'Estudiante ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAuthAssignments() {
        return $this->hasMany(AuthAssignment::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getItemNames() {
        return $this->hasMany(AuthItem::className(), ['name' => 'item_name'])->viaTable('auth_assignment', ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEstudiante() {
        return $this->hasOne(Estudiante::className(), ['id' => 'estudiante_id']);
    }

    /* asda */

    public static function findIdentity($id) {
        return static::findOne($id);
    }

    public function getId() {
        return $this->getPrimaryKey();
    }

    public static function findByUsername($username) {
        return static::find()->where('username=:username and status=1', [':username' => $username])->one();
    }

    public function validatePassword($password, $username) {

//        $cadena =  base64_decode($password);
        $cadena =  mb_convert_encoding(base64_decode($password),"utf8");
        
        
       // mb_convert_encoding($str, "SJIS");
        $tmppass="";
        
        
       /*echo mb_strlen($cadena, 'utf8'); 
        echo strlen($cadena)."<br>";
        echo $cadena."<br><br><br>";*/
        
        for ($i = 0; $i < mb_strlen($cadena); $i++) {
            //echo $cadena[$i]." -  ".$i."<br>";
            //echo mb_substr($cadena,$i,1);
            $tmppass = $tmppass. mb_substr($cadena,$i,1);
            $i+=2;
            
        }
        
        
        
       /*echo $tmppass;
      exit;*/
        $password=$tmppass;
        /*echo $password;
        echo $username;
        exit;*/
        $parametros = array(); //parametros de la llamada
        $parametros['usuario_externo'] = Yii::$app->params["usuarioWS"];
        $parametros['clave_externo'] = Yii::$app->params["claveWS"];
        $servicio = Yii::$app->params["urlWS"]; //url del servicio



        $parametros['usuario'] = $username;
        $parametros['clave'] = $password;



        $opts = array(
            'ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => false
        ));
        $context = stream_context_create($opts);

        $client = new SoapClient($servicio, array('stream_context' => $context, 'soap_version' => SOAP_1_2));
        $result = $client->loginUser($parametros); //llamamos al métdo que nos interesa con los parámetros
        $m_codigo = $result->return->m_codigo;


        //print_r($result);exit;
        if ($m_codigo === 1) {
            //codigo PERUEDUCA
            $userId = $result->return->userId;
            $firstName = $result->return->firstName;
            $lastName = $result->return->lastName;
            $emailAddress = $result->return->emailAddress;
            $userIdString = ($result->return->userId) . "";
            //echo $userIdString.strlen ($userIdString);
            $userIdStringtmp = "";
            for ($i = 0; $i < strlen($userIdString); $i++) {
                $userIdStringtmp = $userIdStringtmp . $userIdString[$i] . "a";
            }


            $parametros = array(); //parametros de la llamada
            //echo base64_encode($userIdStringtmp);

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

            $result2 = $client->loginUserUID($parametros); //llamamos al métdo que nos interesa con los parámetros


            if ($result2->return->codRol == "96021") {
                /* $connectionx = Yii::$app->dbperueduca;
                  $commandx = $connectionx->createCommand("SELECT COUNT(1) AS cantidad FROM bdpadron.padron WHERE ges_dep IN ('A1','A2','A3','A4') AND niv_mod='F0' AND estado='1' AND cod_mod='".$result2->return->codModularIE."'");
                  //$connection->createCommand('SELECT * FROM user')->queryAll();
                  $rowx = $commandx->queryAll();

                  if($rowx[0]["cantidad"] ==0){
                  return false;

                  } */
                $_SESSION["rol"] = "estudiante";
            } else if ($result2->return->codRol == "115089" || $result2->return->codRol == "41622") {
                /* 	$connectionx = Yii::$app->dbperueduca;
                  $commandx = $connectionx->createCommand("SELECT COUNT(1) AS cantidad FROM bdpadron.padron WHERE ges_dep IN ('A1','A2','A3','A4') AND niv_mod='F0' AND estado='1' AND cod_mod='".$result2->return->codModularIE."'");
                  //$connection->createCommand('SELECT * FROM user')->queryAll();
                  $rowx = $commandx->queryAll();

                  if($rowx[0]["cantidad"] ==0){
                  return false;

                  } */
                $_SESSION["rol"] = "docente";
            } else {
                $_SESSION["rol"] = "";
            }





            $model = static::find()->where('userId=:userId', [':userId' => $userId])->one();



            //echo isset(	$model)."dsa";
            if (!isset($model)) {

                if ($_SESSION["rol"] == "") {
                    return false;
                }



                $connectionx = Yii::$app->dbperueduca;
                $commandx = $connectionx->createCommand("SELECT * FROM bdpadron.padron WHERE ges_dep IN ('A1','A2','A3','A4') AND (niv_mod='F0' or niv_mod='D0' or niv_mod='D1' or niv_mod='D2') and estado='1' AND cod_mod='" . $result2->return->codModularIE . "'");
                //$connection->createCommand('SELECT * FROM user')->queryAll();
                $rowxie = $commandx->queryAll();

                if (empty($rowxie)) {
                    return false;
                }



                //$fecha_nacimiento=str_replace("/", "-", $registrar->fecha_nac);
                // $registrar->foto = UploadedFile::getInstance($registrar, 'foto');

                $connectionx = Yii::$app->dbperueduca;
                $commandx = $connectionx->createCommand('SELECT a.userId,a.dni,a.num_doc,a.tipo_doc,b.birthday,b.male FROM User_ a INNER JOIN Contact_ b ON a.userId=b.userId WHERE a.userId=' . $userIdString);
                $rowx = $commandx->queryAll();

                $numero_doc = "";
                if ($rowx[0]["tipo_doc"] == "2") {
                    $numero_doc = $rowx[0]["dni"];
                } else {
                    $numero_doc = $rowx[0]["num_doc"];
                }

                $sexo = "";
                if ($rowx[0]["male"] == "1") {
                    $sexo = "M";
                } else {
                    $sexo = "F";
                }

                $birthday = $rowx[0]["birthday"];
                $connectionx = Yii::$app->db;
                $commandx = $connectionx->createCommand("SELECT * FROM institucion WHERE codigo_modular='" . ($result2->return->codModularIE) . "'");
                $rowx = $commandx->queryAll();

                $institucion_id = "";
                /* print_r($rowx);
                  exit; */
                if (!empty($rowx)) {
                    $institucion_id = $rowx[0]["id"];
                } else {
                    $institucion = new Institucion;
                    $institucion->denominacion = $rowxie[0]["cen_edu"];
                    $institucion->ubigeo_id = $rowxie[0]["codgeo"];
                    $institucion->codigo_modular = $rowxie[0]["cod_mod"];
                    $institucion->latitud = $rowxie[0]["nlat_ie"];
                    $institucion->longitud = $rowxie[0]["nlong_ie"];
                    $institucion->estado = 1;
                    $institucion->save();
                    $institucion_id = $institucion->id;
                }


                $estudiante = new Estudiante;
                $estudiante->nombres = $firstName;
                $estudiante->apellido_paterno = $lastName;
                //$estudiante->apellido_materno=$registrar->apellido_materno;
                //$estudiante->sexo=$registrar->sexo;
                $estudiante->dni = $result2->return->nroDocumento;
                //$estudiante->fecha_nac=date("Y-m-d",strtotime($fecha_nacimiento));
                $estudiante->email = $emailAddress;
                //$estudiante->celular=$registrar->celular;
                $estudiante->institucion_id = $institucion_id;
                //$estudiante->grado=$registrar->grado;


                $estudiante->dni = $numero_doc;
                $estudiante->sexo = $sexo;
                $estudiante->fecha_nac = date("Y-m-d", strtotime($birthday));

                $estudiante->save();



                $usuario = new Usuario;
                $usuario->username = $username;
                //$usuario->password=Yii::$app->getSecurity()->generatePasswordHash($registrar->password);//crypt($registrar->password,"ideasenaccion");
                $usuario->status = 1;
                $usuario->fecha_registro = date("Y-m-d H:i:s");
                $usuario->fecha_actualizacion = date("Y-m-d H:i:s");
                $usuario->estudiante_id = $estudiante->id;

                $usuario->userId = $userId;
                $usuario->status_registro = "1";
                $usuario->save();
                //return $usuario;
                $model = static::find()->where('userId=:userId', [':userId' => $userId])->one();
                $_SESSION["ultimologin"] = $model->fecha_actualizacion;
                return true;
            } else {
                if ($_SESSION["rol"] == "") {
                    $_SESSION["rol"] = "monitor";
                }

                //preguntar si el email es el mismo.. sino actualizar
                $model = static::find()->where('userId=:userId', [':userId' => $userId])->one();
                if ($model->username == $emailAddress) {
                    //$model=static::find()->where('userId=:userId',[':userId' => $userId])->one();
                } else {
                    $model->username = $emailAddress;
                }
                $_SESSION["ultimologin"] = $model->fecha_actualizacion;
                $model->fecha_actualizacion = date("Y-m-d H:i:s");
                $model->save();
                if ($_SESSION["rol"] != "monitor") {
                    $estudiante = Estudiante::find()->where('id=:id', [':id' => $model->estudiante_id])->one();
                    $estudiante->email = $model->username;
                    $estudiante->save();
                }
            }

            return $model;
        } else {

            return false;
        }

        /*
          $model=static::find()->where('username=:username and status=1',[':username' => $username])->one();
          if(Yii::$app->getSecurity()->validatePassword($password, $model->password))
          {
          return $model;
          } */
        return false;
    }

    public function getUsername() {

        return $this->username;
    }

    public static function findIdentityByAccessToken($token, $type = null) {

        if ($user['accessToken'] === $token) {
            return new static($user);
        }
        return null;
    }

    public function getAuthKey() {
        return $this->auth_key;
    }

    public function validateAuthKey($authKey) {
        return $this->getAuthKey() === $authKey;
    }

}
