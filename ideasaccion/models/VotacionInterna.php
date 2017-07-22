<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "votacion_interna".
 *
 * @property integer $id
 * @property integer $proyecto_id
 * @property integer $region_id
 * @property integer $user_id
 */
class VotacionInterna extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public $titulo;
    public $voto;
    public $valor;
    public $resultado;
    public $maximo;
    public $department_id;
    public static function tableName()
    {
        return 'votacion_interna';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['proyecto_id', 'region_id', 'user_id','voto','resultado','department_id'], 'integer'],
            [['titulo'],'safe']
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
            'region_id' => 'Region ID',
            'user_id' => 'User ID',
        ];
    }
    
    public function getProyecto()
    {
        return $this->hasOne(Proyecto::className(), ['id' => 'proyecto_id']);
    }
    
    public function getRegion()
    {
        return $this->hasOne(Ubigeo::className(), ['department_id' => 'region_id']);
    }
    
    public function getUsuario()
    {
        return $this->hasOne(Usuario::className(), ['id' => 'user_id']);
    }
}
