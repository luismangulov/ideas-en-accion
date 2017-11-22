<?php

namespace app\models;
use yii\db\Query;
use Yii;

/**
 * This is the model class for table "resultados".
 *
 * @property integer $id
 * @property integer $asunto_id
 * @property integer $region_id
 * @property integer $cantidad
 */
class Resultados extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public $resultados;
    public $descripcion_cabecera;
    public static function tableName()
    {
        return 'resultados';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['descripcion_cabecera'],'safe'],
            [['asunto_id', 'region_id', 'cantidad'], 'integer']
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
            'region_id' => 'Region ID',
            'cantidad' => 'Cantidad',
        ];
    }
    
    public function getAsunto()
    {
        return $this->hasOne(Asunto::className(), ['id' => 'asunto_id']);
    }
    
    
    public function getForos($region,$sort)
    {
        $query = new Query;
        $query
            ->select([
                        'foro.id',
                        'foro.titulo',
                        '(select count(*) from foro_comentario where foro_comentario.foro_id=foro.id) total',
                        '(select count(*) from foro_comentario where foro_comentario.foro_id=foro.id and foro_comentario.valoracion!=0) valorado',
                        '(select count(*) from foro_comentario where foro_comentario.foro_id=foro.id and foro_comentario.valoracion=0 and not foro_comentario.user_id between 2 and 8) pendiente',
                        '(select count(*) from foro_comentario where foro_comentario.foro_id=foro.id and foro_comentario.valoracion=0 and foro_comentario.user_id between 2 and 8) emitido'
                        ])
            ->from('{{%foro}}')
            ->where('foro.id=2')
            ->groupBy('foro.titulo,total');
            //->orderBy($sort);
            
        $query1 = new Query;
        $query1
            ->select([
                        'foro.id',
                        'foro.titulo',
                        '(select count(*) from foro_comentario where foro_comentario.foro_id=foro.id) total',
                        '(select count(*) from foro_comentario where foro_comentario.foro_id=foro.id and foro_comentario.valoracion!=0) valorado',
                        '(select count(*) from foro_comentario where foro_comentario.foro_id=foro.id and foro_comentario.valoracion=0 and not foro_comentario.user_id between 2 and 8) pendiente',
                        '(select count(*) from foro_comentario where foro_comentario.foro_id=foro.id and foro_comentario.valoracion=0 and foro_comentario.user_id between 2 and 8) emitido'
                        ])
            ->from('{{%foro}}')
            ->innerJoin('resultados','resultados.asunto_id=foro.asunto_id')
            ->innerJoin('asunto','foro.asunto_id=asunto.id')
            ->where('resultados.region_id=:region_id',[':region_id'=>$region])
            ->groupBy('foro.titulo,total');
            //->orderBy($sort);
        
        $query->union($query1);
        $expenses = new Query();
        $expenses->select('*')->from(['u' => $query])->orderBy($sort);
        
        $result = Yii::$app->tools->Pagination($expenses,28);
        
        return ['resultados' => $result['result'], 'pages' => $result['pages']];
    }
}
