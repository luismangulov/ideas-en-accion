<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "vista_resultado".
 *
 * @property integer $id
 * @property integer $proyecto_id
 * @property string $region_id
 * @property integer $equipo_id
 * @property string $nombres_apellidos
 * @property integer $grado
 * @property string $titulo
 * @property string $resumen
 * @property string $beneficiario
 * @property string $denominacion
 * @property string $video
 */
class VistaResultado extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'vista_resultado';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['proyecto_id', 'equipo_id', 'grado'], 'integer'],
            [['region_id'], 'string', 'max' => 2],
            [['nombres_apellidos'], 'string', 'max' => 250],
            [['titulo'], 'string', 'max' => 350],
            [['resumen', 'beneficiario'], 'string', 'max' => 5000],
            [['denominacion', 'ruta'], 'string', 'max' => 1500]
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
            'equipo_id' => 'Equipo ID',
            'nombres_apellidos' => 'Nombres Apellidos',
            'grado' => 'Grado',
            'titulo' => 'Titulo',
            'resumen' => 'Resumen',
            'beneficiario' => 'Beneficiario',
            'denominacion' => 'Denominacion',
        ];
    }
}
