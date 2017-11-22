<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "plan_presupuestal_copia".
 *
 * @property integer $id
 * @property integer $actividad_id
 * @property integer $recurso
 * @property integer $como_conseguirlo
 * @property double $precio_unitario
 * @property integer $cantidad
 * @property double $subtotal
 * @property integer $estado
 *
 * @property ActividadCopia $actividad
 */
class PlanPresupuestalCopia extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'plan_presupuestal_copia';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['actividad_id'], 'required'],
            [['actividad_id', 'recurso', 'como_conseguirlo', 'cantidad', 'estado'], 'integer'],
            [['precio_unitario', 'subtotal'], 'number']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'actividad_id' => 'Actividad ID',
            'recurso' => 'Recurso',
            'como_conseguirlo' => 'Como Conseguirlo',
            'precio_unitario' => 'Precio Unitario',
            'cantidad' => 'Cantidad',
            'subtotal' => 'Subtotal',
            'estado' => 'Estado',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getActividad()
    {
        return $this->hasOne(ActividadCopia::className(), ['id' => 'actividad_id']);
    }
}
