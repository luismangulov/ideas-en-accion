<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "objetivo_especifico".
 *
 * @property integer $id
 * @property integer $proyecto_id
 * @property string $descripcion
 *
 * @property Actividad[] $actividads
 * @property Proyecto $proyecto
 */
class ObjetivoEspecifico extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'objetivo_especifico';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['proyecto_id'], 'integer'],
            [['descripcion'], 'string', 'max' => 250]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'proyecto_id' => 'Proyecto ID',
            'descripcion' => 'Descripcion',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getActividads()
    {
        return $this->hasMany(Actividad::className(), ['objetivo_especifico_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProyecto()
    {
        return $this->hasOne(Proyecto::className(), ['id' => 'proyecto_id']);
    }
}
