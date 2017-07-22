<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Justificacion;

/**
 * JustificacionSearch represents the model behind the search form about `app\models\Justificacion`.
 */
class JustificacionSearch extends Justificacion
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'actividad_id', 'plan_presupuestal_id'], 'integer'],
            [['como_financian'], 'safe'],
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
        $query = Justificacion::find();

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
            'actividad_id' => $this->actividad_id,
            'plan_presupuestal_id' => $this->plan_presupuestal_id,
        ]);

        $query->andFilterWhere(['like', 'como_financian', $this->como_financian]);

        return $dataProvider;
    }
}
