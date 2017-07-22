<?php

namespace app\models;

use Yii;
use yii\web\UploadedFile;
/**
 * This is the model class for table "video".
 *
 * @property integer $id
 * @property integer $proyecto_id
 * @property string $ruta
 */
class Video extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public $archivo;
    public static function tableName()
    {
        return 'video';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['proyecto_id'], 'integer'],
            [['ruta'], 'string', 'max' => 150],
            [['archivo'], 'file'],
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
        ];
    }
    
    public function upload()
    {
        if ($this->validate()) {
            $this->archivo->saveAs('video_carga/' . \Yii::$app->user->id . '.' . $this->archivo->extension,true);
            return true;
        } else {
            return false;
        }
    }
}
