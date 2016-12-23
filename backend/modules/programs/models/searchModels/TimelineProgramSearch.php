<?php

namespace backend\modules\programs\models\searchModels;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\programs\models\TimelineProgram;

/**
 * TimelineProgramSearch represents the model behind the search form about `backend\modules\programs\models\TimelineProgram`.
 */
class TimelineProgramSearch extends TimelineProgram
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'program_id'], 'integer'],
            [['date', 'tv_show','time', 'type', 'days'], 'safe'],
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
        $query = TimelineProgram::find();

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
            'program_id' => $this->program_id,
            'date' => $this->date,
            'time' => $this->time,
        ]);

        $query->andFilterWhere(['like', 'type', $this->type])
            ->andFilterWhere(['like', 'days', $this->days]);

        return $dataProvider;
    }
}