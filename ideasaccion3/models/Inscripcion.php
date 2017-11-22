<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "inscripcion".
 *
 * @property integer $id
 * @property string $codigo_modular
 * @property string $iiee
 * @property string $dni
 * @property string $nombres
 * @property string $paterno
 * @property string $materno
 * @property integer $grado
 * @property string $fec_nac
 * @property string $email
 * @property string $contrasena
 * @property string $celular
 * @property string $equipo
 * @property integer $rol
 * @property string $Registrado
 */
class Inscripcion extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'inscripcion';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['grado', 'rol'], 'integer'],
            [['codigo_modular'], 'string', 'max' => 7],
            [['iiee'], 'string', 'max' => 26],
            [['dni'], 'string', 'max' => 8],
            [['nombres'], 'string', 'max' => 15],
            [['paterno', 'fec_nac'], 'string', 'max' => 10],
            [['materno', 'celular'], 'string', 'max' => 9],
            [['email'], 'string', 'max' => 30],
            [['contrasena'], 'string', 'max' => 11],
            [['equipo'], 'string', 'max' => 35],
            [['Registrado'], 'string', 'max' => 1]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'codigo_modular' => 'Codigo Modular',
            'iiee' => 'Iiee',
            'dni' => 'Dni',
            'nombres' => 'Nombres',
            'paterno' => 'Paterno',
            'materno' => 'Materno',
            'grado' => 'Grado',
            'fec_nac' => 'Fec Nac',
            'email' => 'Email',
            'contrasena' => 'Contrasena',
            'celular' => 'Celular',
            'equipo' => 'Equipo',
            'rol' => 'Rol',
            'Registrado' => 'Registrado',
        ];
    }
}
