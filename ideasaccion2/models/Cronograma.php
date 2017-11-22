<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "cronograma".
 *
 * @property integer $id
 * @property integer $actividad_id
 * @property string $fecha_inicio
 * @property string $fecha_fin
 * @property integer $duracion
 * @property integer $responsable_id
 *
 * @property Actividad $actividad
 */
class Cronograma extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public $objetivo_especifico_id;
    public static function tableName()
    {
        return 'cronograma';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['actividad_id', 'duracion', 'responsable_id'], 'integer'],
            [['fecha_inicio', 'fecha_fin'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'actividad_id' => 'Actividad ID',
            'fecha_inicio' => 'Fecha Inicio',
            'fecha_fin' => 'Fecha Fin',
            'duracion' => 'Duracion',
            'responsable_id' => 'Responsable ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getActividad()
    {
        return $this->hasOne(Actividad::className(), ['id' => 'actividad_id']);
    }
}
