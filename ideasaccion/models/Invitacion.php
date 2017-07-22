<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "invitacion".
 *
 * @property integer $id
 * @property integer $estudiante_id
 * @property integer $estudiante_invitado_id
 * @property integer $estado
 * @property string $fecha_invitacion
 * @property string $fecha_aceptacion
 *
 * @property Estudiante $estudianteInvitado
 * @property Estudiante $estudiante
 */
class Invitacion extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public $invitado;
    public $descripcion_equipo;
    public $nombres_apellidos;
    public $denominacion;
    public $nombres;
    public $apellido_paterno;
    public $apellido_materno;
    public $avatar;
    public static function tableName()
    {
        return 'invitacion';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['estudiante_id', 'estudiante_invitado_id', 'estado'], 'integer'],
            [['fecha_invitacion', 'fecha_aceptacion'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'estudiante_id' => 'Estudiante ID',
            'estudiante_invitado_id' => 'Estudiante Invitado ID',
            'estado' => 'Estado',
            'fecha_invitacion' => 'Fecha Invitacion',
            'fecha_aceptacion' => 'Fecha Aceptacion',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEstudianteInvitado()
    {
        return $this->hasOne(Estudiante::className(), ['id' => 'estudiante_invitado_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEstudiante()
    {
        return $this->hasOne(Estudiante::className(), ['id' => 'estudiante_id']);
    }
}
