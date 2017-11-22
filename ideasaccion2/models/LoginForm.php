<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * LoginForm is the model behind the login form.
 */
class LoginForm extends Model
{
    public $username;
    public $password;
    public $repassword;
    public $rememberMe = true;
    public $verification_code;
    public $captcha;
    private $_user = false;


    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // username and password are both required
            [['username', 'password',"captcha"], 'required'],
            // rememberMe must be a boolean value
            ['rememberMe', 'boolean'],
            [['repassword','verification_code'],'safe'],
            // password is validated by validatePassword()
            ['password', 'validatePassword'],
        ];
    }

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();
            if (!$user || !$user->validatePassword($this->password,$this->username)) {
                Yii::$app->session->setFlash('usuarioincorrecto');
                $this->addError($attribute, 'Incorrect username or password.');
                
            }
        }
    }

    /**
     * Logs in a user using the provided username and password.
     * @return boolean whether the user is logged in successfully
     */
    public function login()
    {
        
        
        $tmpusuario="";
        $cadena2 =  mb_convert_encoding(base64_decode($this->username),"utf8");
        for ($i = 0; $i < mb_strlen($cadena2); $i++) {
            //echo $cadena[$i]." -  ".$i."<br>";
            //echo mb_substr($cadena,$i,1);
            $tmpusuario = $tmpusuario. mb_substr($cadena2,$i,1);
            $i+=2;
            
        }
        //echo $tmpusuario;
        
        
        $this->username=$tmpusuario;
        
        
    	$validador = $this->validate();
        if ($validador) {
            
        	$this->_user = false;
            return Yii::$app->user->login($this->getUser(), $this->rememberMe ? 3600*24*30 : 0);
        }
        return false;
    }

    /**
     * Finds user by [[username]]
     *
     * @return User|null
     */
    public function getUser()
    {
        
        //echo "hola";
          
        if ($this->_user === false) {
        	  
        
            $this->_user = Usuario::findByUsername($this->username);
            if(!isset($this->_user )){
            	$usuario=new Usuario;
                $usuario->username=$this->username;
                $usuario->password=$this->password;
              	$this->_user = $usuario;
            }
            
            /*  */
        }

        return $this->_user;
    }
}
