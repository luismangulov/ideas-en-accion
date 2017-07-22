<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\VotacionInterna;

/**
 * VotacionInternaSearch represents the model behind the search form about `app\models\VotacionInterna`.
 */
class VotacionInternaSearch extends VotacionInterna
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'proyecto_id', 'region_id', 'user_id', 'estado' ,'voto','department_id'], 'integer'],
            [['titulo'],'safe']
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
        $query = VotacionInterna::find();

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
            'proyecto_id' => $this->proyecto_id,
            'region_id' => $this->region_id,
            'user_id' => $this->user_id,
            'estado' => $this->estado,
        ]);

        return $dataProvider;
    }
    
    public function votacion($params)
    {
        $countInterna=VotacionInterna::find()->select(['count(proyecto_id) as maximo'])
                        ->where('estado=2')
                    ->groupBy('proyecto_id')->orderBy('maximo desc')->one();
        //var_dump($countInterna->maximo);die;
        /*$query =    VotacionInterna::find()
                    ->select(['proyecto.id','proyecto.titulo','votacion_interna.region_id','count(proyecto.id) voto','proyecto.valor_porcentual_administrador valor','((count(proyecto.id)/'.$countInterna->maximo.')*0.7 + ((proyecto.valor_porcentual_administrador/40))*0.3)*100  resultado '])
                    ->innerJoin('proyecto','proyecto.id=votacion_interna.proyecto_id')
                    ->where('votacion_interna.estado=2')
                    ->groupBy('proyecto.id,proyecto.titulo,votacion_interna.region_id')
                    ->orderBy('voto desc');
        */            
                    
        $query= Proyecto::find()
                //->select(['proyecto.id','proyecto.titulo','ubigeo.department_id','count(proyecto.id) voto','proyecto.valor_porcentual_administrador valor','((count(proyecto.id)/'.$countInterna->maximo.')*0.7 + ((proyecto.valor_porcentual_administrador/40))*0.3)*100 as resultado '])
                ->select(['proyecto.id','proyecto.titulo','ubigeo.department_id','count(proyecto.id) voto','proyecto.valor_porcentual_administrador valor','proyecto.resultado'])
                ->innerJoin('equipo','equipo.id=proyecto.equipo_id')
                ->innerJoin('integrante','integrante.equipo_id=equipo.id')
                ->innerJoin('estudiante','estudiante.id = integrante.estudiante_id')
                ->innerJoin('institucion','institucion.id = estudiante.institucion_id')
                ->innerJoin('ubigeo','ubigeo.district_id = institucion.ubigeo_id')
                ->leftJoin('votacion_interna','votacion_interna.proyecto_id=proyecto.id AND votacion_interna.estado=2')
                ->where('equipo.etapa=2 AND integrante.rol=1')
                ->groupBy('proyecto.id,proyecto.titulo,ubigeo.department_id')
                ->orderBy('voto desc');
        
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
            //'proyecto_id' => $this->proyecto_id,
            'ubigeo.department_id' => $this->region_id,
            //'user_id' => $this->user_id,
            //'estado' => 2,
        ]);
        
        $query->andFilterWhere(['like', 'proyecto.titulo', $this->titulo]);

        return $dataProvider;
    }
}
