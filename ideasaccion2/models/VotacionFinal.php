<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "votacion_final".
 *
 * @property integer $id
 * @property string $dni
 * @property integer $proyecto_id
 * @property integer $esstado
 */
class VotacionFinal extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'votacion_final';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['proyecto_id', 'estado'], 'integer'],
            [['dni'], 'string', 'max' => 8]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'dni' => 'Dni',
            'proyecto_id' => 'Proyecto ID',
            'estado' => 'Esstado',
        ];
    }
}
