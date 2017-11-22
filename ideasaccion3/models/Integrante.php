<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "integrante".
 *
 * @property integer $equipo_id
 * @property integer $estudiante_id
 * @property integer $rol
 * @property integer $estado
 *
 * @property Equipo $equipo
 * @property Estudiante $estudiante
 */
class Integrante extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public $nombres_apellidos;
    public $department_id;
    public $user_id;
    public $nombres;
    public $apellido_paterno;
    public $apellido_materno;
    public $entrada;
    public static function tableName()
    {
        return 'integrante';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['equipo_id', 'estudiante_id', 'rol', 'estado'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'equipo_id' => 'Equipo ID',
            'estudiante_id' => 'Estudiante ID',
            'rol' => 'Rol',
            'estado' => 'Estado',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEquipo()
    {
        return $this->hasOne(Equipo::className(), ['id' => 'equipo_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEstudiante()
    {
        return $this->hasOne(Estudiante::className(), ['id' => 'estudiante_id']);
    }
}
