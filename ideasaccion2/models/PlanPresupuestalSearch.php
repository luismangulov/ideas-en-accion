<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\PlanPresupuestal;

/**
 * PlanPresupuestalSearch represents the model behind the search form about `app\models\PlanPresupuestal`.
 */
class PlanPresupuestalSearch extends PlanPresupuestal
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'recurso', 'como_conseguirlo', 'cantidad'], 'integer'],
            [['precio_unitario', 'subtotal'], 'number'],
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
        $query = PlanPresupuestal::find();

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
            'recurso' => $this->recurso,
            'como_conseguirlo' => $this->como_conseguirlo,
            'precio_unitario' => $this->precio_unitario,
            'cantidad' => $this->cantidad,
            'subtotal' => $this->subtotal,
        ]);

        return $dataProvider;
    }
}
