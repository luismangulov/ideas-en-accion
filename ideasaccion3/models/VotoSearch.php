<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Voto;

/**
 * VotacionSearch represents the model behind the search form about `app\models\Votacion`.
 */
class VotoSearch extends Voto
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['asunto_id', 'participante_id', 'estado'], 'integer'],
            [['region_id', 'fecha_registro'], 'safe'],
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
        $query = Voto::find();

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
            'asunto_id' => $this->asunto_id,
            'participante_id' => $this->participante_id,
            'fecha_registro' => $this->fecha_registro,
            'estado' => $this->estado,
        ]);

        $query->andFilterWhere(['like', 'region_id', $this->region_id]);

        return $dataProvider;
    }
}
