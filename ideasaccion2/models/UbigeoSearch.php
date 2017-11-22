<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Ubigeo;

/**
 * UbigeoSearch represents the model behind the search form about `app\models\Ubigeo`.
 */
class UbigeoSearch extends Ubigeo
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['department_id', 'province_id', 'district_id', 'pais', 'department', 'province', 'district', 'pais_id', 'district_id_standart'], 'safe'],
            [['latitude', 'longitud'], 'number'],
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
        $query = Ubigeo::find();

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
            'latitude' => $this->latitude,
            'longitud' => $this->longitud,
        ]);

        $query->andFilterWhere(['like', 'department_id', $this->department_id])
            ->andFilterWhere(['like', 'province_id', $this->province_id])
            ->andFilterWhere(['like', 'district_id', $this->district_id])
            ->andFilterWhere(['like', 'pais', $this->pais])
            ->andFilterWhere(['like', 'department', $this->department])
            ->andFilterWhere(['like', 'province', $this->province])
            ->andFilterWhere(['like', 'district', $this->district])
            ->andFilterWhere(['like', 'pais_id', $this->pais_id])
            ->andFilterWhere(['like', 'district_id_standart', $this->district_id_standart]);

        return $dataProvider;
    }
}
