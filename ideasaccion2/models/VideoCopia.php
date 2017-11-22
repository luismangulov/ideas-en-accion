<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "video_copia".
 *
 * @property integer $id
 * @property integer $proyecto_id
 * @property string $ruta
 * @property integer $etapa
 */
class VideoCopia extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'video_copia';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['proyecto_id', 'etapa'], 'integer'],
            [['ruta'], 'string', 'max' => 150]
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
            'ruta' => 'Ruta',
            'etapa' => 'Etapa',
        ];
    }
}
