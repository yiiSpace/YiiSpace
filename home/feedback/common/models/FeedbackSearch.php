<?php

namespace home\feedback\common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use home\feedback\common\models\Feedback;

/**
 * FeedbackSearch represents the model behind the search form about `home\feedback\common\models\Feedback`.
 */
class FeedbackSearch extends Feedback
{
    public $date_to = '' ;
    public $date_from = '' ;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'cate_id', 'type_id', 'reply_at', 'admin_updated_by', 'created_at', 'updated_at', 'status','hot_grade'], 'integer'],
            [['username', 'id_card', 'tel', 'contact_address', 'subject', 'body', 'reply_department', 'reply_content'], 'safe'],
            [['date_to','date_from'], 'safe'],
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
        $query = Feedback::find();

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
            'cate_id' => $this->cate_id,
            'type_id' => $this->type_id,
            'reply_at' => $this->reply_at,
            'admin_updated_by' => $this->admin_updated_by,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'status' => $this->status,
            'hot_grade' => $this->hot_grade,
        ]);

        $query->andFilterWhere(['like', 'username', $this->username])
            ->andFilterWhere(['like', 'id_card', $this->id_card])
            ->andFilterWhere(['like', 'tel', $this->tel])
            ->andFilterWhere(['like', 'contact_address', $this->contact_address])
            ->andFilterWhere(['like', 'subject', $this->subject])
            ->andFilterWhere(['like', 'body', $this->body])
            ->andFilterWhere(['like', 'reply_department', $this->reply_department])
            ->andFilterWhere(['like', 'reply_content', $this->reply_content]);

        return $dataProvider;
    }
}
