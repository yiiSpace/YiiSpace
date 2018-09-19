<?php

namespace year\user\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use year\user\models\User;

/**
 * UserSearch represents the model behind the search form about `year\user\models\User`.
 */
class UserSearch extends User
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'status', 'last_active_at', 'created_at'], 'integer'],
            [['username', 'email', 'icon_url', 'password', 'salt', 'last_login_ip'], 'safe'],
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

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'status' => $this->status,
            'last_active_at' => $this->last_active_at,
            'created_at' => $this->created_at,
        ]);

        $query->andFilterWhere(['like', 'username', $this->username])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'icon_url', $this->icon_url])
            ->andFilterWhere(['like', 'password', $this->password])
            ->andFilterWhere(['like', 'salt', $this->salt])
            ->andFilterWhere(['like', 'last_login_ip', $this->last_login_ip]);

        return $dataProvider;
    }
}
