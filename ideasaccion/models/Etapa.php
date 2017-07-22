<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "etapa".
 *
 * @property integer $id
 * @property integer $etapa
 * @property integer $estado
 */
class Etapa extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'etapa';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['etapa', 'estado'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'etapa' => 'Etapa',
            'estado' => 'Estado',
        ];
    }
}
