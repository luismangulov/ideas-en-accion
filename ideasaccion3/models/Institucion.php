<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "institucion".
 *
 * @property integer $id
 * @property string $denominacion
 * @property string $ruc
 * @property string $telefono
 * @property string $direccion
 * @property string $ubigeo_id
 * @property string $codigo_modular
 * @property integer $estado
 * @property integer $unidad_gestion_educativa_local_id
 * @property integer $tipo_institucion
 * @property string $ruta_escale
 * @property integer $jec
 */
class Institucion extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public $estudiante_id;
    public $department_id;
    public static function tableName()
    {
        return 'institucion';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['estado', 'unidad_gestion_educativa_local_id', 'tipo_institucion', 'jec'], 'integer'],
            [['denominacion'], 'string', 'max' => 250],
            [['ruc'], 'string', 'max' => 12],
            [['telefono'], 'string', 'max' => 25],
            [['direccion'], 'string', 'max' => 200],
            [['ubigeo_id'], 'string', 'max' => 6],
            [['codigo_modular'], 'string', 'max' => 100],
            [['ruta_escale'], 'string', 'max' => 500]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'denominacion' => 'Denominacion',
            'ruc' => 'Ruc',
            'telefono' => 'Telefono',
            'direccion' => 'Direccion',
            'ubigeo_id' => 'Ubigeo ID',
            'codigo_modular' => 'Codigo Modular',
            'estado' => 'Estado',
            'unidad_gestion_educativa_local_id' => 'Unidad Gestion Educativa Local ID',
            'tipo_institucion' => 'Tipo Institucion',
            'ruta_escale' => 'Ruta Escale',
            'jec' => 'Jec',
        ];
    }
}
