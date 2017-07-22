<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "actividad".
 *
 * @property integer $id
 * @property integer $objetivo_especifico_id
 * @property string $descripcion
 * @property string $resultado_esperado
 *
 * @property ObjetivoEspecifico $objetivoEspecifico
 * @property Cronograma[] $cronogramas
 * @property PlanPresupuestal[] $planPresupuestals
 */
class Actividad extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public $objetivos_especificos;
    public $actividades;
    public $resultados_esperados;
    public $actividad_id;
    
    public $recursos;
    public $comos_conseguirlos;
    public $precios_unitarios;
    public $cantidades;
    public $subtotales;
    public $responsables;
    public $fechas_inicios;
    public $fechas_fines;
    public $planes_presupuestal_ids;
    public $cronogramas_ids;
    public static function tableName()
    {
        return 'actividad';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            //[['objetivos_especificos','actividades','resultados_esperados'],'required'],
            [['objetivo_especifico_id'], 'integer'],
            [['descripcion'], 'string', 'max' => 250],
            [['resultado_esperado'], 'string', 'max' => 15],
            [['objetivos_especificos','actividades','resultados_esperados',
              'recursos','comos_conseguirlos','precios_unitarios','cantidades','subtotales','responsables',
              'fechas_inicios','fechas_fines','planes_presupuestal_ids','cronogramas_ids'],'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'objetivo_especifico_id' => 'Objetivo Especifico ID',
            'descripcion' => 'Descripcion',
            'resultado_esperado' => 'Resultado Esperado',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getObjetivoEspecifico()
    {
        return $this->hasOne(ObjetivoEspecifico::className(), ['id' => 'objetivo_especifico_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCronogramas()
    {
        return $this->hasMany(Cronograma::className(), ['actividad_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPlanPresupuestals()
    {
        return $this->hasMany(PlanPresupuestal::className(), ['actividad_int' => 'id']);
    }
}
