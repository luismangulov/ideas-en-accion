<?php

namespace app\models;

use yii\db\Query;
use Yii;

/**
 * This is the model class for table "estudiante".
 *
 * @property integer $id
 * @property integer $institucion_id
 * @property string $nombres_apellidos
 * @property string $sexo
 * @property string $dni
 * @property string $fecha_nacimiento
 * @property string $email
 * @property string $celular
 * @property integer $grado
 *
 * @property Encuesta[] $encuestas
 * @property Institucion $institucion
 * @property Integrante[] $integrantes
 * @property Invitacion[] $invitacions
 * @property Invitacion[] $invitacions0
 * @property Usuario[] $usuarios
 */
class Estudiante extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public $total_estudiantes;
    public $region_id;
    public $estado;
    public $denominacion;

    public static function tableName() {
        return 'estudiante';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            //[['id'], 'required'],
            [['id', 'institucion_id', 'grado', 'estado'], 'integer'],
            [['fecha_nac'], 'safe'],
            [['nombres', 'apellido_paterno', 'apellido_materno', 'region_id'], 'string', 'max' => 250],
            [['sexo'], 'string', 'max' => 10],
            [['dni'], 'string', 'max' => 8],
            [['email'], 'string', 'max' => 150],
            [['celular'], 'string', 'max' => 9]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'institucion_id' => 'Institucion ID',
            'nombres_apellidos' => 'Nombres Apellidos',
            'sexo' => 'Sexo',
            'dni' => 'Dni',
            'fecha_nac' => 'Fecha Nacimiento',
            'email' => 'Email',
            'celular' => 'Celular',
            'grado' => 'Grado',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEncuestas() {
        return $this->hasMany(Encuesta::className(), ['alumno_id' => 'id']);
    }

    public function getEstudiantex($estudiante_id) {
        //return $this->hasOne(['id' => $estudiante_id]);
        return static::findOne($estudiante_id);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInstitucion() {
        return $this->hasOne(Institucion::className(), ['id' => 'institucion_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIntegrantes() {
        return $this->hasMany(Integrante::className(), ['estudiante_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInvitacions() {
        return $this->hasMany(Invitacion::className(), ['estudiante_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInvitacions0() {
        return $this->hasMany(Invitacion::className(), ['estudiante_invitado_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsuarios() {
        return $this->hasMany(Usuario::className(), ['alumno_id' => 'id']);
    }

    public function getGrado() {
        $descripcion = "";
        if ($this->grado == 1) {
            $descripcion = "Primero";
        } elseif ($this->grado == 2) {
            $descripcion = "Segundo";
        } elseif ($this->grado == 3) {
            $descripcion = "Tercero";
        } elseif ($this->grado == 4) {
            $descripcion = "Cuarto";
        } elseif ($this->grado == 5) {
            $descripcion = "Quinto";
        }

        return $descripcion;
    }

    public function getRegistrados($sort) {

        $query = new Query;
        $query
                ->select(['distinct department,
                         ifnull((SELECT count(DISTINCT E.id) FROM estudiante E INNER JOIN institucion I ON I.id = E.institucion_id INNER JOIN ubigeo U ON U.district_id = I.ubigeo_id where U.department_id=ubigeo.department_id GROUP BY U.department),0) as total_estudiantes,
                        ifnull((SELECT count(DISTINCT E.id) FROM estudiante E INNER JOIN institucion I ON I.id = E.institucion_id INNER JOIN ubigeo U ON U.district_id = I.ubigeo_id 
                            INNER JOIN integrante n ON E.id = n.estudiante_id INNER JOIN equipo eq ON n.equipo_id = eq.id WHERE eq.estado = 1 and U.department_id=ubigeo.department_id GROUP BY U.department),0) as estudiantes_finalizaron_equipo,
                         ifnull((SELECT count(DISTINCT E.id) FROM estudiante E INNER JOIN institucion I ON I.id = E.institucion_id INNER JOIN ubigeo U ON U.district_id = I.ubigeo_id 
                            INNER JOIN integrante n ON E.id = n.estudiante_id INNER JOIN equipo eq ON n.equipo_id = eq.id WHERE eq.estado = 0 and U.department_id=ubigeo.department_id GROUP BY U.department),0) as estudiantes_aceptaron_invitacion,
                         ifnull((SELECT count(DISTINCT E.id) FROM estudiante E INNER JOIN institucion I ON I.id = E.institucion_id 
                            INNER JOIN ubigeo U ON U.district_id = I.ubigeo_id  INNER JOIN invitacion inv ON inv.estudiante_invitado_id = E.id WHERE inv.estado = 1 and U.department_id=ubigeo.department_id GROUP BY U.department),0) as estudiantes_invitaciones_pendientes,
                         ifnull((SELECT count(DISTINCT E.id) FROM estudiante E INNER JOIN institucion I ON I.id = E.institucion_id 
                            INNER JOIN ubigeo U ON U.district_id = I.ubigeo_id WHERE E.id NOT IN (SELECT estudiante_id FROM integrante UNION ALL SELECT estudiante_invitado_id FROM invitacion WHERE estado = 1) and U.department_id=ubigeo.department_id GROUP BY U.department),0) as estudiantes_huerfanos
                '])
                ->from('{{%ubigeo}}')
                ->orderBy($sort);

        $result = Yii::$app->tools->Pagination($query, 27);

        return ['registrados' => $result['result'], 'pages' => $result['pages']];
    }

    public function getRegistradosDetalles($region, $estado, $sort) {

        $query = new Query;
        if ($estado == 1) {
            $query
                    ->select('institucion.denominacion,estudiante.nombres,estudiante.apellido_paterno,estudiante.apellido_materno,estudiante.email,estudiante.celular,estudiante.grado')
                    ->from('{{%estudiante}}')
                    ->innerJoin('institucion', 'institucion.id = estudiante.institucion_id')
                    ->innerJoin('ubigeo', 'ubigeo.district_id = institucion.ubigeo_id')
                    ->innerJoin('integrante', 'estudiante.id = integrante.estudiante_id')
                    ->innerJoin('equipo', 'integrante.equipo_id = equipo.id')
                    ->where('equipo.estado = 1 and ubigeo.department_id=:department_id', [':department_id' => $region])
                    ->orderBy($sort);
        } elseif ($estado == 2) {
            $query
                    ->select('institucion.denominacion,estudiante.nombres,estudiante.apellido_paterno,estudiante.apellido_materno,estudiante.email,estudiante.celular,estudiante.grado')
                    ->from('{{%estudiante}}')
                    ->innerJoin('institucion', 'institucion.id = estudiante.institucion_id')
                    ->innerJoin('ubigeo', 'ubigeo.district_id = institucion.ubigeo_id')
                    ->innerJoin('integrante', 'estudiante.id = integrante.estudiante_id')
                    ->innerJoin('equipo', 'integrante.equipo_id = equipo.id')
                    ->where('equipo.estado = 0 and ubigeo.department_id=:department_id', [':department_id' => $region])
                    ->orderBy($sort);
        } elseif ($estado == 3) {
            $query
                    ->select('institucion.denominacion,estudiante.nombres,estudiante.apellido_paterno,estudiante.apellido_materno,estudiante.email,estudiante.celular,estudiante.grado')
                    ->from('{{%estudiante}}')
                    ->innerJoin('institucion', 'institucion.id = estudiante.institucion_id')
                    ->innerJoin('ubigeo', 'ubigeo.district_id = institucion.ubigeo_id')
                    ->innerJoin('invitacion', 'invitacion.estudiante_invitado_id = estudiante.id')
                    ->where('invitacion.estado = 1 and ubigeo.department_id=:department_id', [':department_id' => $region])
                    ->orderBy($sort);
        } elseif ($estado == 4) {
            $query
                    ->select('institucion.denominacion,estudiante.nombres,estudiante.apellido_paterno,estudiante.apellido_materno,estudiante.email,estudiante.celular,estudiante.grado')
                    ->from('{{%estudiante}}')
                    ->innerJoin('institucion', 'institucion.id = estudiante.institucion_id')
                    ->innerJoin('ubigeo', 'ubigeo.district_id = institucion.ubigeo_id')
                    ->where('estudiante.id NOT IN (SELECT estudiante_id FROM integrante UNION ALL SELECT estudiante_invitado_id FROM invitacion WHERE estado = 1) and ubigeo.department_id=:department_id', [':department_id' => $region])
                    ->orderBy($sort);
        } elseif ($region) {
            $query
                    ->select('institucion.denominacion,estudiante.nombres,estudiante.apellido_paterno,estudiante.apellido_materno,estudiante.email,estudiante.celular,estudiante.grado')
                    ->from('{{%estudiante}}')
                    ->innerJoin('institucion', 'institucion.id = estudiante.institucion_id')
                    ->innerJoin('ubigeo', 'ubigeo.district_id = institucion.ubigeo_id')
                    ->where('ubigeo.department_id=:department_id', [':department_id' => $region])
                    ->orderBy($sort)
                    ->limit(10);
        } else {
            $query
                    ->select('institucion.denominacion,estudiante.nombres,estudiante.apellido_paterno,estudiante.apellido_materno,estudiante.email,estudiante.celular,estudiante.grado')
                    ->from('{{%estudiante}}')
                    ->innerJoin('institucion', 'institucion.id = estudiante.institucion_id')
                    ->innerJoin('ubigeo', 'ubigeo.district_id = institucion.ubigeo_id')
                    ->orderBy($sort)
                    ->limit(10);
        }


        $result = Yii::$app->tools->Pagination($query);

        return ['registrados' => $result['result'], 'pages' => $result['pages']];
    }

}
