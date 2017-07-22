<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "justificacion".
 *
 * @property integer $id
 * @property integer $actividad_id
 * @property integer $plan_presupuestal_id
 * @property string $como_financian
 *
 * @property PlanPresupuestal $planPresupuestal
 */
class Justificacion extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'justificacion';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['actividad_id', 'plan_presupuestal_id'], 'integer'],
            [['como_financian'], 'string', 'max' => 250]
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
            'plan_presupuestal_id' => 'Plan Presupuestal ID',
            'como_financian' => 'Como Financian',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPlanPresupuestal()
    {
        return $this->hasOne(PlanPresupuestal::className(), ['id' => 'plan_presupuestal_id']);
    }
}
