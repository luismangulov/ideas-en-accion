<?php

namespace app\models;
use yii\db\Query;
use Yii;
use yii\web\UploadedFile;
/**
 * This is the model class for table "equipo".
 *
 * @property integer $id
 * @property integer $asunto_id
 * @property string $descripcion_equipo
 * @property string $descripcion
 * @property integer $estado
 * @property string $fecha_registro
 *
 * @property Asunto $asunto
 * @property Integrante[] $integrantes
 */
class Equipo extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public $participante;
    public $id_participante;
    public $invitaciones;
    public $invitaciones_docente;
    public $tipo;
    public $foto_img;
    public $email;
    public static function tableName()
    {
        return 'equipo';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['descripcion_equipo','descripcion'], 'required'],
            [['asunto_id', 'estado','id','tipo'], 'integer'],
            [['fecha_registro','invitaciones','invitaciones_docente'], 'safe'],
            [['descripcion_equipo','email'], 'string', 'max' => 250],
            [['descripcion'], 'string', 'max' => 500],
            [['foto_img'], 'file'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'asunto_id' => 'Asunto ID',
            'descripcion_equipo' => 'Descripcion Equipo',
            'descripcion' => 'Descripcion',
            'estado' => 'Estado',
            'fecha_registro' => 'Fecha Registro',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAsunto()
    {
        return $this->hasOne(Asunto::className(), ['id' => 'asunto_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIntegrantes()
    {
        return $this->hasMany(Integrante::className(), ['equipo_id' => 'id']);
    }
    
    public function validarmiebros($invitados)
    {
        foreach($invitados as $invitado => $key)
        {
            
            $integrante=Integrante::find()
                        ->select('estudiante.nombres_apellidos')
                        ->innerJoin('estudiante','estudiante.id=integrante.estudiante_id')
                        ->where('estudiante_id=:estudiante_id',[':estudiante_id'=>(integer) $key])->one();
                        
            
        }
    }
    
    public function getEquipos($sort)
    {
        //total_equipos province   total_alumnos  district  total_equipos_nofinalizado latitude  total_alumnos_nofinalizado longitud
        $query = new Query;
        $query
            ->select(['DISTINCT ubigeo.department,
                      (SELECT COUNT( equipo.id ) FROM equipo INNER JOIN integrante ON integrante.equipo_id = equipo.id INNER JOIN estudiante ON estudiante.id = integrante.estudiante_id AND integrante.rol =1 INNER JOIN institucion ON institucion.id = estudiante.institucion_id INNER JOIN ubigeo u ON u.district_id = institucion.ubigeo_id WHERE u.department_id = ubigeo.department_id AND equipo.estado =1 ) AS province,
                      (SELECT COUNT( equipo.id ) FROM equipo INNER JOIN integrante ON integrante.equipo_id = equipo.id INNER JOIN estudiante ON estudiante.id = integrante.estudiante_id INNER JOIN institucion ON institucion.id = estudiante.institucion_id INNER JOIN ubigeo u ON u.district_id = institucion.ubigeo_id WHERE u.department_id = ubigeo.department_id AND equipo.estado =1 ) AS district ,
                      (SELECT COUNT( equipo.id ) FROM equipo INNER JOIN integrante ON integrante.equipo_id = equipo.id INNER JOIN estudiante ON estudiante.id = integrante.estudiante_id AND integrante.rol =1 INNER JOIN institucion ON institucion.id = estudiante.institucion_id INNER JOIN ubigeo u ON u.district_id = institucion.ubigeo_id WHERE u.department_id = ubigeo.department_id AND equipo.estado =0 ) AS latitude,
                      (SELECT COUNT( equipo.id ) FROM equipo INNER JOIN integrante ON integrante.equipo_id = equipo.id INNER JOIN estudiante ON estudiante.id = integrante.estudiante_id INNER JOIN institucion ON institucion.id = estudiante.institucion_id INNER JOIN ubigeo u ON u.district_id = institucion.ubigeo_id WHERE u.department_id = ubigeo.department_id AND equipo.estado =0 ) AS longitud
                    '])
            ->from('{{%ubigeo}}')
            ->orderBy($sort);
            
        $result = Yii::$app->tools->Pagination($query,27);
        
        return ['equipos' => $result['result'], 'pages' => $result['pages']];
    }
}
