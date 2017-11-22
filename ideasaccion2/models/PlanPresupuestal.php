<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "plan_presupuestal".
 *
 * @property integer $id
 * @property integer $recurso
 * @property integer $como_conseguirlo
 * @property double $precio_unitario
 * @property integer $cantidad
 * @property double $subtotal
 *
 * @property Actividad $comoConseguirlo
 */
class PlanPresupuestal extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public $objetivo_especifico_id;
    public static function tableName()
    {
        return 'plan_presupuestal';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['recurso', 'como_conseguirlo'], 'integer'],
            [['precio_unitario', 'subtotal'], 'number'],
            [['recurso_descripcion'], 'string', 'max' => 200],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'recurso' => 'Recurso',
            'como_conseguirlo' => 'Como Conseguirlo',
            'precio_unitario' => 'Precio Unitario',
            'cantidad' => 'Cantidad',
            'subtotal' => 'Subtotal',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getComoConseguirlo()
    {
        return $this->hasOne(Actividad::className(), ['id' => 'como_conseguirlo']);
    }
}
