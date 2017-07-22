<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "objetivo_especifico_copia".
 *
 * @property integer $id
 * @property integer $proyecto_id
 * @property string $descripcion
 *
 * @property ActividadCopia[] $actividadCopias
 * @property ProyectoCopia $proyecto
 */
class ObjetivoEspecificoCopia extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'objetivo_especifico_copia';
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
    public function getActividadCopias()
    {
        return $this->hasMany(ActividadCopia::className(), ['objetivo_especifico_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProyecto()
    {
        return $this->hasOne(ProyectoCopia::className(), ['id' => 'proyecto_id']);
    }
}
