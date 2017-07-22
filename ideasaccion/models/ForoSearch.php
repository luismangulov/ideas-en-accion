<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Foro;

/**
 * ForoSearch represents the model behind the search form about `app\models\Foro`.
 */
class ForoSearch extends Foro
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'creado_at', 'actualizado_at', 'user_id', 'post_count'], 'integer'],
            [['titulo', 'descripcion'], 'safe'],
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
        $query = Foro::find();

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
            'creado_at' => $this->creado_at,
            'actualizado_at' => $this->actualizado_at,
            'user_id' => $this->user_id,
            'post_count' => $this->post_count,
        ]);

        $query->andFilterWhere(['like', 'titulo', $this->titulo])
            ->andFilterWhere(['like', 'descripcion', $this->descripcion]);

        return $dataProvider;
    }
}
