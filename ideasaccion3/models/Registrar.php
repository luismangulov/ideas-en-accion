<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\web\UploadedFile;

/**
 * ContactForm is the model behind the contact form.
 */
class Registrar extends Model {

    //public $nombres_apellidos;
    //ublic $proyecto_trabajar_donde;
    public $sexo;
    public $dni;
    public $fecha_nac;
    public $email;
    public $celular;
    public $departamento;
    public $provincia;
    public $distrito;
    public $institucion;
    public $grado;
    public $p1;
    public $p2;
    public $p3;
    public $p4;
    public $p5;
    public $p6;
    public $password;
    public $repassword;
    public $nombres;
    public $apellido_paterno;
    public $apellido_materno;
    public $foto;
    public $avatar;

    /**
     * @return array the validation rules.
     */
    public function rules() {
        return [
            // name, email, subject and body are required
            [['grado'], 'required'],
            // email has to be a valid email address
            [['sexo', 'departamento', 'provincia', 'distrito', 'institucion'], 'string', 'max' => 10],
            [['celular'], 'string', 'max' => 9],
            /* [['email','password','repassword','nombres','apellido_paterno','apellido_materno'], 'string', 'max' => 250], */

            /* [['dni','celular','grado'],'integer'], */
            [['fecha_nac', 'p1', 'p2', 'p3', 'p4', 'p5', 'p6'], 'safe'],
            /* [['email'],'email'], */
            /* ['repassword','compare','compareAttribute'=>'password'], */
            [['foto'], 'file'],
                //['email', 'email'],
                // verifyCode needs to be entered correctly
                //['verifyCode', 'captcha'],
        ];
    }

    /**
     * @return array customized attribute labels
     */
    /**
     * Sends an email to the specified email address using the information collected by this model.
     * @param  string  $email the target email address
     * @return boolean whether the model passes validation
     */
}
