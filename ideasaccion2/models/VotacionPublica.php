<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "votacion_publica".
 *
 * @property integer $id
 * @property integer $proyecto_id
 * @property integer $region_id
 * @property integer $estado
 * @property string $fecha_registro
 */
class VotacionPublica extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public $denominacion;
    public $titulo;
    public $resumen;
    public $equipo_id;
    public $tipo;
    public $ruta;
    public $votos;
    public static function tableName()
    {
        return 'votacion_publica';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['proyecto_id', 'region_id', 'estado'], 'integer'],
            [['fecha_registro'], 'safe']
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
            'estado' => 'Estado',
            'fecha_registro' => 'Fecha Registro',
        ];
    }
    
    public function getProyecto()
    {
        return $this->hasOne(Proyecto::className(), ['id' => 'proyecto_id']);
    }
}
