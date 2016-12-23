<?php

namespace backend\modules\baner\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\baner\models\Baner;

/**
 * SearchBaner represents the model behind the search form about `backend\modules\baner\models\Baner`.
 */
class SearchBaner extends Baner
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'news_id', 'order', 'active'], 'integer'],
            [['title_ua', 'title_ru', 'description_ua', 'description_ru'], 'string'],
            [['img_link'], 'safe'],
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
        $query = Baner::find();

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
            'news_id' => $this->news_id,
            'order' => $this->order,
            'active' => $this->active,
            'title_ua' => $this->title_ua,
            'title_ru' => $this->title_ru,
            'description_ua' => $this->description_ua,
            'description_ru' => $this->description_ru
        ]);

        $query->andFilterWhere(['like', 'img_link', $this->img_link]);

        return $dataProvider;
    }
}
