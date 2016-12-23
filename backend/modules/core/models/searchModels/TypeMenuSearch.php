<?php

namespace backend\modules\core\models\searchModels;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\core\models\TypeMenu;

class TypeMenuSearch extends TypeMenu
{

    public function rules()
    {
        return [
            [['id', 'display_order', 'active'], 'integer'],
            [['code', 'title'], 'safe'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = TypeMenu::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'display_order' => $this->display_order,
            'active' => $this->active,
        ]);

        $query->andFilterWhere(['like', 'code', $this->code]);
        $query->andFilterWhere(['like', 'title', $this->title]);

        return $dataProvider;
    }
}