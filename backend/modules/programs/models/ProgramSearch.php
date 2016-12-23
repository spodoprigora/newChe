<?php

namespace backend\modules\programs\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\programs\models\Programs;

/**
 * ProgramSearch represents the model behind the search form about `backend\modules\programs\models\Programs`.
 */
class ProgramSearch extends Programs
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'active', 'display_order', 'is_public_rss', 'is_main',  'preview_id', 'genre_id'], 'integer'],
            [['name_ua', 'name_ru', 'title_ua', 'title_ru', 'short_description_ua', 'short_description_ru', 'description_ua', 'description_ru', 'meta_title_ua', 'meta_title_ru', 'meta_keywords_ua', 'meta_keywords_ru', 'meta_description_ua', 'meta_description_ru'], 'safe'],
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
        $query = Programs::find()->where(['is_main' => '0']);

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
            'active' => $this->active,
            'display_order' => $this->display_order,
            'is_public_rss' => $this->is_public_rss,
            'is_main' => $this->is_main,
            'preview_id' => $this->preview_id,
            'genre_id' => $this->genre_id,
        ]);

        $query->andFilterWhere(['like', 'name_ua', $this->name_ua])
            ->andFilterWhere(['like', 'name_ru', $this->name_ru])
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
