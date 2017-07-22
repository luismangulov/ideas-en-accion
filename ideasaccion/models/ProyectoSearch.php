<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Proyecto;

/**
 * ProyectoSearch represents the model behind the search form about `app\models\Proyecto`.
 */
class ProyectoSearch extends Proyecto
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'user_id','region_id','asunto_id','total_monitor','total_estudiante','total_monitor_respuesta'], 'integer'],
            [['titulo', 'resumen', 'objetivo_general','forum_url'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $usuario=Usuario::findOne(\Yii::$app->user->id);
        $estudiante=Estudiante::findOne($usuario->estudiante_id);
        $integrante=Integrante::find()->where('estudiante_id=:estudiante_id',[':estudiante_id'=>$estudiante->id])->one();
        //$equipo=Equipo::find()->where('id=:id',[':id'=>$integrante->equipo_id])->one();
        
        $query = Proyecto::find()
                    ->select('foro.id foro_id,proyecto.id,proyecto.titulo,proyecto.region_id')
                    ->innerJoin('equipo','equipo.id=proyecto.equipo_id')
                    ->innerJoin('asunto','asunto.id=proyecto.asunto_id')
                    ->innerJoin('foro','foro.proyecto_id=proyecto.id')
                    ->where('proyecto.equipo_id not in ('.$integrante->equipo_id.') and equipo.etapa in (1,2)')
                    ->groupBy('proyecto.titulo,foro_id')
                    ->orderBy('RAND()');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            //'proyecto.user_id' => \Yii::$app->user->id,
            //'equipo.etapa'=>1,
            'proyecto.region_id'=>$this->region_id,
            'asunto.id'=>$this->asunto_id,
        ]);

        $query->andFilterWhere(['like', 'proyecto.titulo', $this->titulo])
            ->andFilterWhere(['like', 'resumen', $this->resumen]);
            
            

        return $dataProvider;
    }
    
    public function monitor($params)
    {
       
        
        $query = Proyecto::find()
                    ->select(['foro.id foro_id','proyecto.id','proyecto.titulo',
                              '(select count(*) from foro_comentario where foro_comentario.foro_id=foro.id and foro_comentario.user_id between 2 and 8) as total_monitor',
                              '(select count(*) from foro_comentario where foro_comentario.foro_id=foro.id and foro_comentario.user_id>=9) as total_estudiante',
                              '(SELECT count(*) FROM foro_comentario m 
                                INNER JOIN foro_comentario r ON r.foro_comentario_hijo_id=m.id
                                WHERE m.user_id BETWEEN 2 AND 8 AND r.user_id NOT IN (2,3,4,5,6,7,8) AND m.foro_id=foro.id ) as total_monitor_respuesta',
                              'proyecto.region_id'])
                    ->innerJoin('equipo','equipo.id=proyecto.equipo_id')
                    ->innerJoin('asunto','asunto.id=proyecto.asunto_id')
                    ->innerJoin('foro','foro.proyecto_id=proyecto.id')
                    ->where(' equipo.etapa in (1,2)')
                    ->groupBy('proyecto.titulo,foro_id');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            //'proyecto.user_id' => \Yii::$app->user->id,
            //'equipo.etapa'=>1,
            'proyecto.region_id'=>$this->region_id,
        ]);

        $query->andFilterWhere(['like', 'proyecto.titulo', $this->titulo])
            ->andFilterWhere(['like', 'resumen', $this->resumen]);
            
            

        return $dataProvider;
    }
    
    public function votacion($params)
    {
        
        $query = Proyecto::find()
                    ->select('foro.id foro_id ,proyecto.id,proyecto.titulo,proyecto.region_id')
                    //->innerJoin('ubigeo','ubigeo.department_id=proyecto.region_id')
                    ->innerJoin('equipo','equipo.id=proyecto.equipo_id')
                    //->innerJoin('integrante','integrante.')
                    ->innerJoin('asunto','asunto.id=equipo.asunto_id')
                    ->innerJoin('foro','foro.proyecto_id=proyecto.id')
                    ->where('equipo.etapa in (2)')
                    ->groupBy('proyecto.titulo,foro.id');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            //'proyecto.user_id' => \Yii::$app->user->id,
            //'equipo.etapa'=>1,
            'proyecto.region_id'=>$this->region_id
        ]);

        $query->andFilterWhere(['like', 'proyecto.titulo', $this->titulo])
            ->andFilterWhere(['like', 'resumen', $this->resumen]);
            
            

        return $dataProvider;
    }
    
    
    public function votacionAdmin($params)
    {
        
        $query = Proyecto::find()
                    ->select('foro.id foro_id ,proyecto.id,proyecto.titulo,proyecto.region_id')
                    //->innerJoin('ubigeo','ubigeo.department_id=proyecto.region_id')
                    ->innerJoin('equipo','equipo.id=proyecto.equipo_id')
                    //->innerJoin('integrante','integrante.')
                    ->innerJoin('asunto','asunto.id=equipo.asunto_id')
                    ->innerJoin('foro','foro.proyecto_id=proyecto.id')
                    ->where('equipo.etapa in (2)')
                    ->groupBy('proyecto.titulo,foro.id');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            //'proyecto.user_id' => \Yii::$app->user->id,
            //'equipo.etapa'=>1,
            'proyecto.region_id'=>$this->region_id
        ]);

        $query->andFilterWhere(['like', 'proyecto.titulo', $this->titulo])
            ->andFilterWhere(['like', 'resumen', $this->resumen]);
            
            

        return $dataProvider;
    }
    
}
