<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "reflexion".
 *
 * @property integer $id
 * @property integer $proyecto_id
 * @property integer $user_id
 * @property string $reflexion
 */
class Reflexion extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'reflexion';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['proyecto_id', 'user_id','p4','p5_1','p5_2','p5_3','p5_4','p5_5','p5_6','p5_7','p5_8','p6','p7_1','p7_2','p7_3','p7_4','p7_5','p7_6','p7_7','p7_8','p8'], 'integer'],
            [['p1','p2','p3'], 'string', 'max' => 5000]
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
            'user_id' => 'User ID',
            'p1' => 'Reflexion',
        ];
    }
    
    public function getUsuario()
    {
        return $this->hasOne(Usuario::className(), ['id' => 'user_id']);
    }
}
