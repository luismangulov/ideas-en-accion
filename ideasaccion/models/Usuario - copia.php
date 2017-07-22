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
            [['username', 'password'], 'string', 'max' => 100],
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

        $servicio = "https://api.perueduca.pe/wsPeruEducaN/services/User_Service?wsdl"; //url del servicio
        $parametros = array(); //parametros de la llamada
        $parametros['usuario'] = $username;
        $parametros['clave'] = $password;
        $parametros['usuario_externo'] = "educared";
        $parametros['clave_externo'] = "RUryTXwUM96cQQN";
        $client = new SoapClient($servicio, $parametros);
        $result = $client->loginUser($parametros); //llamamos al métdo que nos interesa con los parámetros
        $m_codigo = $result->return->m_codigo;


        print_r($result);exit;
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

            $servicio = "https://api.perueduca.pe/wsPeruEducaN/services/User_Service?wsdl"; //url del servicio
            $parametros = array(); //parametros de la llamada
            //echo base64_encode($userIdStringtmp);
            $parametros['token'] = base64_encode($userIdStringtmp);
            $parametros['usuario_externo'] = "educared";
            $parametros['clave_externo'] = "RUryTXwUM96cQQN";
            $client = new SoapClient($servicio, $parametros);
            $result2 = $client->loginUserUID($parametros); //llamamos al métdo que nos interesa con los parámetros


            $model = static::find()->where('userId=:userId', [':userId' => $userId])->one();
            //echo isset(	$model)."dsa";
            if (!isset($model)) {

                //$fecha_nacimiento=str_replace("/", "-", $registrar->fecha_nac);
                // $registrar->foto = UploadedFile::getInstance($registrar, 'foto');
                $estudiante = new Estudiante;
                $estudiante->nombres = $firstName;
                $estudiante->apellido_paterno = $lastName;
                //$estudiante->apellido_materno=$registrar->apellido_materno;
                //$estudiante->sexo=$registrar->sexo;
                $estudiante->dni = $result2->return->nroDocumento;
                //$estudiante->fecha_nac=date("Y-m-d",strtotime($fecha_nacimiento));
                $estudiante->email = $emailAddress;
                //$estudiante->celular=$registrar->celular;
                //$estudiante->institucion_id=$registrar->institucion;
                //$estudiante->grado=$registrar->grado;
                $estudiante->save();


                $usuario = new Usuario;
                $usuario->username = $username;
                //$usuario->password=Yii::$app->getSecurity()->generatePasswordHash($registrar->password);//crypt($registrar->password,"ideasenaccion");
                $usuario->status = 1;
                $usuario->fecha_registro = date("Y-m-d H:i:s");
                $usuario->estudiante_id = $estudiante->id;
                $usuario->userId = $userId;
                $usuario->save();
            } else {
                //preguntar si el email es el mismo.. sino actualizar
                $model = static::find()->where('userId=:userId', [':userId' => $userId])->one();
                if ($username == $emailAddress) {
                    //$model=static::find()->where('userId=:userId',[':userId' => $userId])->one();
                } else {
                    $model->username = $emailAddress;
                    $model->save();
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
