<?php

namespace backend\modules\gallery\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\gallery\models\Preview;

/**
 * PreviewSearch represents the model behind the search form about `backend\modules\gallery\models\Preview`.
 */
class PreviewSearch extends Preview
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['url', 'alt_ua', 'alt_ru', 'title_ua', 'title_ru'], 'safe'],
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
        $query = Preview::find();

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

        $query->andFilterWhere(['like', 'url', $this->url])
            ->andFilterWhere(['like', 'alt_ua', $this->alt_ua])
            ->andFilterWhere(['like', 'alt_ru', $this->alt_ru])
            ->andFilterWhere(['like', 'title_ua', $this->title_ua])
            ->andFilterWhere(['like', 'title_ru', $this->title_ru]);

        return $dataProvider;
    }
}
