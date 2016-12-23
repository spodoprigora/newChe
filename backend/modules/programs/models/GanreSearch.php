<?php

namespace backend\modules\programs\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\programs\models\Ganre;

/**
 * GanreSearch represents the model behind the search form about `backend\modules\programs\models\Ganre`.
 */
class GanreSearch extends Ganre
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['name_ua', 'name_ru'], 'safe'],
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
        $query = Ganre::find();

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
        ]);

        $query->andFilterWhere(['like', 'name_ua', $this->name_ua])
            ->andFilterWhere(['like', 'name_ru', $this->name_ru]);

        return $dataProvider;
    }
}
