<?php

namespace year\status\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use year\status\models\Status;

/**
 * StatusSearch represents the model behind the search form about `year\status\models\Status`.
 */
class StatusSearch extends Status
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'creator_id', 'create_at', 'profile_id', 'approved'], 'integer'],
            [['content', 'type'], 'safe'],
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
        $query = Status::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'creator_id' => $this->creator_id,
            'create_at' => $this->create_at,
            'profile_id' => $this->profile_id,
            'approved' => $this->approved,
        ]);

        $query->andFilterWhere(['like', 'content', $this->content])
            ->andFilterWhere(['like', 'type', $this->type]);

        return $dataProvider;
    }
}
