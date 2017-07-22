<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "encuesta".
 *
 * @property integer $id
 * @property integer $estudiante_id
 * @property string $p1_1
 * @property string $p1_2
 * @property string $p1_3
 * @property string $p1_4
 * @property string $p2
 * @property string $p3_1
 * @property string $p3_2
 * @property string $p3_3
 * @property string $p3_4
 * @property string $p3_5
 * @property string $p3_6
 * @property string $p4_1
 * @property string $p4_2
 * @property string $p4_3
 * @property string $p4_4
 * @property string $p4_5
 * @property string $p4_6
 * @property string $p5_1
 * @property string $p5_2
 * @property string $p6_1
 * @property string $p6_2
 * @property string $p6_3
 * @property string $p6_4
 *
 * @property Estudiante $estudiante
 */
class Encuesta extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'encuesta';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['estudiante_id'], 'integer'],
            [['p1_1', 'p1_2', 'p1_3', 'p1_4', 'p3_1', 'p3_2', 'p3_3', 'p3_4', 'p3_5', 'p3_6', 'p4_1', 'p4_2', 'p4_3', 'p4_4', 'p4_5', 'p4_6', 'p5_1', 'p5_2', 'p6_1', 'p6_2', 'p6_3', 'p6_4'], 'string', 'max' => 250],
            [['p2'], 'string', 'max' => 11]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'estudiante_id' => 'Estudiante ID',
            'p1_1' => 'P1 1',
            'p1_2' => 'P1 2',
            'p1_3' => 'P1 3',
            'p1_4' => 'P1 4',
            'p2' => 'P2',
            'p3_1' => 'P3 1',
            'p3_2' => 'P3 2',
            'p3_3' => 'P3 3',
            'p3_4' => 'P3 4',
            'p3_5' => 'P3 5',
            'p3_6' => 'P3 6',
            'p4_1' => 'P4 1',
            'p4_2' => 'P4 2',
            'p4_3' => 'P4 3',
            'p4_4' => 'P4 4',
            'p4_5' => 'P4 5',
            'p4_6' => 'P4 6',
            'p5_1' => 'P5 1',
            'p5_2' => 'P5 2',
            'p6_1' => 'P6 1',
            'p6_2' => 'P6 2',
            'p6_3' => 'P6 3',
            'p6_4' => 'P6 4',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEstudiante()
    {
        return $this->hasOne(Estudiante::className(), ['id' => 'estudiante_id']);
    }
}
