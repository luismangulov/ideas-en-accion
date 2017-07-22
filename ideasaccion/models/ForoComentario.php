<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "foro_comentario".
 *
 * @property integer $id
 * @property string $contenido
 * @property integer $foro_id
 * @property integer $user_id
 * @property integer $creado_at
 */
class ForoComentario extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'foro_comentario';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            //[['id'], 'required'],
            [['id', 'foro_id', 'user_id', 'creado_at','estado'], 'integer'],
            [['contenido'], 'string', 'max' => 1500]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'contenido' => 'Contenido',
            'foro_id' => 'Foro ID',
            'user_id' => 'User ID',
            'creado_at' => 'Creado At',
        ];
    }
    
    public function beforeSave($insert)
    {
        $this->PostCuntPlus();
        if (parent::beforeSave($insert)) {
            if ($this->isNewRecord) {
            	$this->user_id = Yii::$app->user->id;
            	$this->creado_at = time();
                $this->estado=1;
            }
            return true;
        } else {
            return false;
        }
    }
    
    public function PostCuntPlus()
    {
        return Yii::$app->db->createCommand("UPDATE {{%foro}} SET post_count=post_count+1 WHERE id=".$this->foro_id)->execute();
    }
    
    public function getUsuario()
    {
        return $this->hasOne(Usuario::className(), ['id' => 'user_id']);
    }
}
