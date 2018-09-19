<?php

namespace my\test\common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use my\test\common\models\User;

/**
 * UserSearch represents the model behind the search form about `my\test\common\models\User`.
 */
class UserSearch extends User
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'superuser', 'status'], 'integer'],
            [['username', 'password', 'icon_uri', 'email', 'activkey', 'create_at', 'lastvisit_at'], 'safe'],
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
        $query = User::find();

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
            'superuser' => $this->superuser,
            'status' => $this->status,
            'create_at' => $this->create_at,
            'lastvisit_at' => $this->lastvisit_at,
        ]);

        $query->andFilterWhere(['like', 'username', $this->username])
            ->andFilterWhere(['like', 'password', $this->password])
            ->andFilterWhere(['like', 'icon_uri', $this->icon_uri])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'activkey', $this->activkey]);

        return $dataProvider;
    }
}
