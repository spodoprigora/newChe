<?php

namespace backend\modules\core\models\searchModels;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\core\models\Pages;

/**
 * PagesSearch represents the model behind the search form about `backend\modules\core\models\Pages`.
 */
class PagesSearch extends Pages
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'parent_id', 'display_order', 'active'], 'integer'],
            [['header_ua', 'header_ru', 'uri', 'full_uri', 'route', 'module', 'menu_class', 'content_ua', 'content_ru', 'meta_title_ua', 'meta_title_ru', 'meta_description_ua', 'meta_description_ru', 'meta_keywords_ua', 'meta_keywords_ru'], 'safe'],
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
        //$query = Pages::find()->where(['module' => 'core']);
        $query = Pages::find();

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
            'parent_id' => $this->parent_id,
            'display_order' => $this->display_order,
            'active' => $this->active,
        ]);

        $query->andFilterWhere(['like', 'header_ua', $this->header_ua])
            ->andFilterWhere(['like', 'header_ru', $this->header_ru])
            ->andFilterWhere(['like', 'uri', $this->uri])
            ->andFilterWhere(['like', 'full_uri', $this->full_uri])
           // ->andFilterWhere(['like', 'route', $this->route])
            ->andFilterWhere(['like', 'module', $this->module])
            ->andFilterWhere(['like', 'menu_class', $this->menu_class])
            ->andFilterWhere(['like', 'content_ua', $this->content_ua])
            ->andFilterWhere(['like', 'content_ru', $this->content_ru])
            ->andFilterWhere(['like', 'meta_title_ua', $this->meta_title_ua])
            ->andFilterWhere(['like', 'meta_title_ru', $this->meta_title_ru])
            ->andFilterWhere(['like', 'meta_description_ua', $this->meta_description_ua])
            ->andFilterWhere(['like', 'meta_description_ru', $this->meta_description_ru])
            ->andFilterWhere(['like', 'meta_keywords_ua', $this->meta_keywords_ua])
            ->andFilterWhere(['like', 'meta_keywords_ru', $this->meta_keywords_ru]);

        return $dataProvider;
    }
}