<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "proyecto".
 *
 * @property integer $id
 * @property string $titulo
 * @property string $resumen
 * @property string $justificacion
 * @property string $objetivo_general
 * @property string $beneficiario_directo_1
 * @property string $beneficiario_directo_2
 * @property string $beneficiario_directo_3
 * @property string $beneficiario_indirecto_1
 * @property string $beneficiario_indirecto_2
 * @property string $beneficiario_indirecto_3
 * @property integer $user_id
 *
 * @property ObjetivoEspecifico[] $objetivoEspecificos
 * @property Usuario $user
 */
class ProyectoCopia extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public $objetivo_especifico_1;
    public $objetivo_especifico_1_id;
    public $objetivo_especifico_2;
    public $objetivo_especifico_2_id;
    public $objetivo_especifico_3;
    public $objetivo_especifico_3_id;
    public $actividades_1;
    public $actividades_2;
    public $actividades_3;
    public $objetivo_especifico_id;
    public $actividad_id;
    public $actividades_ids_1;
    public $actividades_ids_2;
    public $actividades_ids_3;
    public $p1;
    public $p2;
    public $p3;
    public $p4;
    public $p5_1;
    public $p5_2;
    public $p5_3;
    public $p5_4;
    public $p5_5;
    public $p5_6;
    public $p5_7;
    public $p5_8;
    public $p6;
    public $p7_1;
    public $p7_2;
    public $p7_3;
    public $p7_4;
    public $p7_5;
    public $p7_6;
    public $p7_7;
    public $p7_8;
    public $p8;
    public $evaluacion;
    public $forum_url;
    public static function tableName()
    {
        return 'proyecto_copia';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id','actividades_1','actividades_2','actividades_3','actividades_ids_1','actividades_ids_2','actividades_ids_3'],'safe'],
            [['user_id','asunto_id','objetivo_especifico_1_id','objetivo_especifico_2_id','objetivo_especifico_3_id','equipo_id'], 'integer'],
            [['titulo'], 'string', 'max' => 20],
            [['resumen','beneficiario','evaluacion'], 'string', 'max' => 25000],
            [['forum_url','reflexion','objetivo_general','objetivo_especifico_1','objetivo_especifico_2','objetivo_especifico_3'], 'string', 'max' => 300],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'titulo' => 'Titulo',
            'resumen' => 'Resumen',
            'justificacion' => 'Justificacion',
            'objetivo_general' => 'Objetivo General',
            'user_id' => 'User ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getObjetivoEspecificosCopia()
    {
        return $this->hasMany(ObjetivoEspecifico::className(), ['proyecto_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(Usuario::className(), ['id' => 'user_id']);
    }
    
}
