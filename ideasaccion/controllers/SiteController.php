<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\Estudiante;
use app\models\Institucion;
use app\models\Ubigeo;
use app\models\Usuario;
use app\models\Resultados;
use app\models\LogSesion;

class SiteController extends Controller {

    public function behaviors() {

        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    public function actions() {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public function actionIndex() {
        exit;
        return $this->redirect(['site/votacion']);
    }

    public function actionBases() {
        $this->layout = 'minedu';
        return $this->render('bases');
    }

    public function actionLogin() {

        $this->layout = 'login';
        /* if (!\Yii::$app->user->isGuest) {
          return $this->goHome();
          } */
        $mensajeerror = "";
        if ((Yii::$app->session->hasFlash('mensajeerror'))) {
            $mensajeerror = (Yii::$app->session->getFlash('mensajeerror'));
        }


        if (!\Yii::$app->user->isGuest) {

            Yii::$app->user->logout();
            //return $this->redirect(['panel/index']);
        }

        $model = new LoginForm();
        //print_r( Yii::$app->request->post()['LoginForm']['username'] );
        /* $usuario_nuevo=Yii::$app->request->post()['LoginForm']['username'];
          $clave_nuevo=Yii::$app->request->post()['LoginForm']['password']; */
        //	echo Yii::$app->request->post()['LoginForm'];
        //echo $clave_nuevo;
        //echo  $_SESSION["captcha_code"];exit;

        if ($mensajeerror != "") {
            Yii::$app->session->setFlash('mensajeerror', 'El usuario no pertenece a una institución educativa focalizada');
        }

        if ($model->load(Yii::$app->request->post())) {

            if (isset($_SESSION["captcha_code"])) {
                if ($_SESSION["captcha_code"] != $model->captcha) {
                    Yii::$app->session->setFlash('errorCaptcha');
                    return $this->redirect(['/site/index']);
                }
            }
        }
       /* echo $model->username;
        exit;*/
        if ($model->load(Yii::$app->request->post()) && $model->login()) {

            $log = new LogSesion();
            $log->user_id = \Yii::$app->user->id;
            $log->hora_logeo = date("Y-m-d H:i:s");
            $log->save();
            Yii::$app->session->setFlash('lightbox');

            $usuario = Usuario::findOne(\Yii::$app->user->id);

            if ($usuario->name_temporal == "Adminitrador") {
                return $this->redirect(['/panel/ideas-accion']);
            } else if ($usuario->name_temporal == "Monitor") {
                return $this->redirect(['/panel/foros']);
            }



            $estudiante = Estudiante::find()->where('id=:id', [':id' => $usuario->estudiante_id])->one();

            return $this->redirect(['/registrar']);
        }
        return $this->render('login', [
                    'model' => $model,
        ]);
    }

    public function actionLogout() {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    public function actionResultados() {
        $this->layout = 'mapa';
        return $this->render('resultados');
    }

    public function actionRecuperar() {
        $this->layout = 'registrar';
        $usuario = new LoginForm;
        if ($usuario->load(Yii::$app->request->post())) {
            $urlRecuperar = \Yii::$app->request->BaseUrl . Yii::$app->getUrlManager()->createUrl('site/resetear');
            $usuario = Usuario::find()->where('username=:username', [':username' => $usuario->username])->one();
            $usuario->verification_code = $this->randKey("abcdefghijklmnopqrstuvwxyz0123456789", 24);
            $usuario->update();

            $subject = "Bienvenido a la plataforma de ideas en acción";
            $content = "¡Hola!<br><br>
                     Deseaste restablecer tu clave de Ideas en Acción, ¿verdad? Si es así, solo tienes que hacer clic<br><br>
                     <a href='http://intranet.ideasenaccion.pe/site/resetear?url=" . $usuario->verification_code . "'>[AQUÍ]</a><br><br>
                     <br>
                     ";
            Yii::$app->mail->compose('@app/mail/layouts/html', ['content' => $content])
                    ->setFrom('info@ideasenaccion.pe')
                    ->setTo($usuario->username)
                    ->setSubject($subject)
                    ->send();

            Yii::$app->session->setFlash('claveenviada');
            return $this->render('recuperar', ['usuario' => $usuario]);
        }
        return $this->render('recuperar', ['usuario' => $usuario]);
    }

    public function actionResetear($url) {
        $this->layout = 'registrar';
        $loginForm = new LoginForm;
        $usuario = Usuario::find()->where('verification_code=:verification_code', [':verification_code' => $url])->one();
        if ($usuario) {
            if ($loginForm->load(Yii::$app->request->post())) {
                $usuario->verification_code = "";
                $usuario->password = Yii::$app->getSecurity()->generatePasswordHash($loginForm->password);
                $usuario->update();
                return $this->refresh();
            }
            return $this->render('resetear', ['loginForm' => $loginForm]);
        } else {
            return $this->redirect(['site/login']);
        }
    }

    private function randKey($str = '', $long = 0) {
        $key = null;
        $str = str_split($str);
        $start = 0;
        $limit = count($str) - 1;
        for ($x = 0; $x < $long; $x++) {
            $key .= $str[rand($start, $limit)];
        }
        return $key;
    }

    public function actionVotacion() {
        exit;
        $this->layout = 'minedu';
        $resultados = Resultados::find()->all();
        if ($resultados) {
            //return $this->render('votacion');//cambiar a subir a produccion
            return $this->redirect(['site/resultados']);
        } else {
            return $this->render('votacion');
        }
    }

    public function actionError() {
        $this->layout = 'prueba';
        return $this->render('error');
    }

}
