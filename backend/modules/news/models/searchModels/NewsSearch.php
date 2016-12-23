<?php

namespace backend\modules\news\models\searchModels;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\news\models\News;

/**
 * NewsSearch represents the model behind the search form about `backend\modules\news\models\News`.
 */
class NewsSearch extends News
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'date_news',  'program_id', 'is_advertising', 'advertising_time', 'is_primary', 'primary_time', 'is_main', 'gelery_id', 'is_public_rss', 'show_in_last_stories', 'show', 'show_in_actual', 'is_announcement', 'translate_ru'], 'integer'],
            [['type', 'title_ua', 'title_ru', 'short_description_ua', 'short_description_ru', 'description_ua', 'description_ru', 'meta_title_ua', 'meta_title_ru', 'meta_keywords_ua', 'meta_keywords_ru', 'meta_description_ua', 'meta_description_ru'], 'safe'],
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
        $query = News::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query->orderBy(['id' => SORT_DESC]),
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
            'date_news' => $this->date_news,
            'program_id' => $this->program_id,
            'is_advertising' => $this->is_advertising,
            'advertising_time' => $this->advertising_time,
            'is_primary' => $this->is_primary,
            'primary_time' => $this->primary_time,
            'is_main' => $this->is_main,
            'gelery_id' => $this->gelery_id,
            'is_public_rss' => $this->is_public_rss,
            'show_in_last_stories' => $this->show_in_last_stories,
            'show' => $this->show,
            'show_in_actual' => $this->show_in_actual,
            'is_announcement' => $this->is_announcement,
            'translate_ru'          => $this->translate_ru,
        ]);

        $query->andFilterWhere(['like', 'type', $this->type])
            ->andFilterWhere(['like', 'title_ua', $this->title_ua])
            ->andFilterWhere(['like', 'title_ru', $this->title_ru])
            ->andFilterWhere(['like', 'short_description_ua', $this->short_description_ua])
            ->andFilterWhere(['like', 'short_description_ru', $this->short_description_ru])
            ->andFilterWhere(['like', 'description_ua', $this->description_ua])
            ->andFilterWhere(['like', 'description_ru', $this->description_ru])
            ->andFilterWhere(['like', 'meta_title_ua', $this->meta_title_ua])
            ->andFilterWhere(['like', 'meta_title_ru', $this->meta_title_ru])
            ->andFilterWhere(['like', 'meta_keywords_ua', $this->meta_keywords_ua])
            ->andFilterWhere(['like', 'meta_keywords_ru', $this->meta_keywords_ru])
            ->andFilterWhere(['like', 'meta_description_ua', $this->meta_description_ua])
            ->andFilterWhere(['like', 'meta_description_ru', $this->meta_description_ru]);

        return $dataProvider;
    }
}