<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "asunto".
 *
 * @property integer $id
 * @property string $descripcion_cabecera
 * @property integer $estado
 * @property integer $hijo_id
 * @property integer $padre_id
 * @property string $descripcion_larga
 * @property string $descripcion_corta
 *
 * @property Equipo[] $equipos
 * @property Voto[] $votos
 */
class Asunto extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'asunto';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'required'],
            [['id', 'estado', 'hijo_id', 'padre_id'], 'integer'],
            [['descripcion_cabecera'], 'string', 'max' => 250],
            [['descripcion_larga', 'descripcion_corta'], 'string', 'max' => 1000]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'descripcion_cabecera' => 'Descripcion Cabecera',
            'estado' => 'Estado',
            'hijo_id' => 'Hijo ID',
            'padre_id' => 'Padre ID',
            'descripcion_larga' => 'Descripcion Larga',
            'descripcion_corta' => 'Descripcion Corta',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEquipos()
    {
        return $this->hasMany(Equipo::className(), ['asunto_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVotos()
    {
        return $this->hasMany(Voto::className(), ['asunto_id' => 'id']);
    }
}
