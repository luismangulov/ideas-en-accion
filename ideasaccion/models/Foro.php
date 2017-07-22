<?php

namespace app\models;
use yii\db\Query;
use Yii;

/**
 * This is the model class for table "foro".
 *
 * @property integer $id
 * @property string $titulo
 * @property string $descripcion
 * @property integer $creado_at
 * @property integer $actualizado_at
 * @property integer $user_id
 * @property integer $post_count
 */
class Foro extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public $nombres_apellidos;
    public $total;
    public $pendiente;
    public $valorado;
    public $emitido;
    
    public static function tableName()
    {
        return 'foro';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['creado_at', 'actualizado_at', 'user_id', 'post_count','id','foro_id'], 'integer'],
            [['titulo'], 'string', 'max' => 250],
            [['descripcion'], 'string', 'max' => 1500]
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
            'descripcion' => 'Descripcion',
            'creado_at' => 'Creado At',
            'actualizado_at' => 'Actualizado At',
            'user_id' => 'User ID',
            'post_count' => 'Post Count',
            'foro_id' => 'Foro id',
        ];
    }
    
    
    
    public function getUsuario()
    {
        return $this->hasOne(Usuario::className(), ['id' => 'user_id']);
    }
    
    public function getAsunto()
    {
        return $this->hasOne(Asunto::className(), ['id' => 'asunto_id']);
    }
    
    public function getProyecto()
    {
        return $this->hasOne(Proyecto::className(), ['id' => 'proyecto_id']);
    }
    
    public function getPosts($id)
    {
        $query = new Query;
        $query->select('p.id,  p.contenido, p.creado_at, p.foro_id, p.foro_comentario_hijo_id,p.user_id, u.username, u.avatar , es.nombres, es.apellido_paterno , p.valoracion , p.estado')
            ->from('{{%foro_comentario}} as p')
            ->join('LEFT JOIN','{{%usuario}} as u', 'u.id=p.user_id')
            ->join('INNER JOIN','{{%estudiante}} as es', 'es.id=u.estudiante_id')
            ->where('p.foro_id=:id and estado=1 and foro_comentario_hijo_id is null ', [':id' => $this->id])
            ->orderBy('p.id desc');
        
        $query1 = new Query;
        $query1->select('p.id,  p.contenido, p.creado_at, p.foro_id, p.foro_comentario_hijo_id,p.user_id, u.username, u.avatar , u.name_temporal as nombres , u.username , p.valoracion , p.estado')
            ->from('{{%foro_comentario}} as p')
            ->join('LEFT JOIN','{{%usuario}} as u', 'u.id=p.user_id')
            ->where('p.foro_id=:id and estado=1 and foro_comentario_hijo_id is null and u.id between 2 and 8', [':id' => $this->id]);
        
        $query->union($query1);
        $expenses = new Query();
        $expenses->select('*')->from(['u' => $query])->orderBy('u.id desc');
        
        
        $result = Yii::$app->tools->Pagination($expenses,10);
        /*if($id==2){
            $result = Yii::$app->tools->Pagination($expenses,10);
        }elseif($id>=3 && $id<=35) {
            $result = Yii::$app->tools->Pagination($expenses,10);
        } else{
            $result = Yii::$app->tools->Pagination($expenses,10);
        }*/
        return ['posts' => $result['result'], 'pages' => $result['pages']];
    }
    
    public function getForo1Entrega($id,$seccion)
    {
        $query = new Query;
        $query->select(['p.id',  'p.contenido', 'p.creado_at','p.user_id', 'u.username', 'u.avatar', 'CONCAT(es.nombres," ",es.apellido_paterno," ",es.apellido_materno) as nombres', 'es.apellido_paterno' , 'p.valoracion' , 'p.estado', 'ub.department','inst.denominacion'])
            ->from('{{%foro_comentario}} as p')
            ->join('LEFT JOIN','{{%usuario}} as u', 'u.id=p.user_id')
            ->join('INNER JOIN','{{%estudiante}} as es', 'es.id=u.estudiante_id')
            ->join('INNER JOIN','{{%institucion}} as inst', 'inst.id=es.institucion_id')
            ->join('INNER JOIN','{{%ubigeo}} as ub', 'ub.district_id=inst.ubigeo_id')
            ->where('p.foro_id=:id and p.estado=1 and p.seccion=:seccion', [':id' => $this->id,':seccion'=>$seccion])
            ->orderBy('p.id desc');
        
        $query1 = new Query;
        $query1->select(['p.id',  'p.contenido', 'p.creado_at', 'p.user_id', 'u.username', 'u.avatar' , 'u.name_temporal as nombres' , 'u.username' , 'p.valoracion' , 'p.estado' ,'u.username', 'u.username'])
            ->from('{{%foro_comentario}} as p')
            ->join('LEFT JOIN','{{%usuario}} as u', 'u.id=p.user_id')
            ->where('p.seccion=:seccion and p.foro_id=:id and estado=1 and u.id between 2 and 8', [':id' => $this->id,':seccion'=>$seccion]);
        
        $query->union($query1);
        $expenses = new Query();
        $expenses->select(['*'])->from(['u' => $query])->orderBy('u.id desc');
        
        
        $result = Yii::$app->tools->Pagination($expenses,4);
        /*if($id==2){
            $result = Yii::$app->tools->Pagination($expenses,10);
        }elseif($id>=3 && $id<=35) {
            $result = Yii::$app->tools->Pagination($expenses,10);
        } else{
            $result = Yii::$app->tools->Pagination($expenses,10);
        }*/
        return ['posts' => $result['result'], 'pages' => $result['pages']];
    }
    
    
    public function getPostsAdmin($id)
    {
        $query = new Query;
        $query->select('p.id,  p.contenido, p.creado_at, p.user_id, u.username, u.avatar , es.nombres, es.apellido_paterno , p.valoracion , p.estado')
            ->from('{{%foro_comentario}} as p')
            ->join('LEFT JOIN','{{%usuario}} as u', 'u.id=p.user_id')
            ->join('INNER JOIN','{{%estudiante}} as es', 'es.id=u.estudiante_id')
            ->where('p.foro_id=:id and foro_comentario_hijo_id is null ', [':id' => $this->id]);
        
        $query1 = new Query;
        $query1->select('p.id,  p.contenido, p.creado_at, p.user_id, u.username, u.avatar , u.name_temporal as nombres , u.username , p.valoracion , p.estado')
            ->from('{{%foro_comentario}} as p')
            ->join('LEFT JOIN','{{%usuario}} as u', 'u.id=p.user_id')
            ->where('p.foro_id=:id and foro_comentario_hijo_id is null and u.id between 2 and 8', [':id' => $this->id]);
        
        $query->union($query1);
        $expenses = new Query();
        $expenses->select('*')->from(['u' => $query])->orderBy('u.id desc');

        $result = Yii::$app->tools->Pagination($expenses,10);
        
        return ['posts' => $result['result'], 'pages' => $result['pages']];
    }
}
