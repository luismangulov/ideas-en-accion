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
class Asunto_categoria extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'asunto_categoria';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'required'],
            [['id'], 'integer'],
            [['asunto_categoria', 'estado'], 'string', 'max' => 250]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'asunto_categoria' => 'Descripcion Categoría',
            'estado' => 'Estado'
        ];
    }


}
