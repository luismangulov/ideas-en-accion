<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "log_sesion".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $hora_logeo
 */
class LogSesion extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'log_sesion';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id'], 'integer'],
            [['hora_logeo'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'hora_logeo' => 'Hora Logeo',
        ];
    }
}
