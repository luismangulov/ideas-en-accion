<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\ForoComentario;

/**
 * ForoComentarioSearch represents the model behind the search form about `app\models\ForoComentario`.
 */
class ForoComentarioSearch extends ForoComentario
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'foro_id', 'user_id', 'creado_at'], 'integer'],
            [['contenido'], 'safe'],
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
        $query = ForoComentario::find();

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
            'foro_id' => $this->foro_id,
            'user_id' => $this->user_id,
            'creado_at' => $this->creado_at,
        ]);

        $query->andFilterWhere(['like', 'contenido', $this->contenido]);

        return $dataProvider;
    }
}
