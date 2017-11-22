<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "vista_integrantes".
 *
 * @property integer $id
 * @property string $nombres
 * @property string $apellido_paterno
 * @property string $apellido_materno
 * @property integer $grado
 * @property integer $equipo_id
 */
class VistaIntegrantes extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'vista_integrantes';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['grado', 'equipo_id'], 'integer'],
            [['nombres', 'apellido_paterno', 'apellido_materno'], 'string', 'max' => 250]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nombres' => 'Nombres',
            'apellido_paterno' => 'Apellido Paterno',
            'apellido_materno' => 'Apellido Materno',
            'grado' => 'Grado',
            'equipo_id' => 'Equipo ID',
        ];
    }
}
