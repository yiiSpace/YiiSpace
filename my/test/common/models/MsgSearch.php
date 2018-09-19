<?php

namespace my\test\common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use my\test\common\models\Msg;

/**
 * MsgSearch represents the model behind the search form about `my\test\common\models\Msg`.
 */
class MsgSearch extends Msg
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'uid', 'snd_type', 'snd_status', 'priority', 'to_id', 'msg_pid', 'create_time', 'sent_time', 'delete_time'], 'integer'],
            [['type', 'data'], 'safe'],
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
        $query = Msg::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'uid' => $this->uid,
            'snd_type' => $this->snd_type,
            'snd_status' => $this->snd_status,
            'priority' => $this->priority,
            'to_id' => $this->to_id,
            'msg_pid' => $this->msg_pid,
            'create_time' => $this->create_time,
            'sent_time' => $this->sent_time,
            'delete_time' => $this->delete_time,
        ]);

        $query->andFilterWhere(['like', 'type', $this->type])
            ->andFilterWhere(['like', 'data', $this->data]);

        return $dataProvider;
    }
}
