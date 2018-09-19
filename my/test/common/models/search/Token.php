<?php

namespace my\test\common\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use my\test\common\models\Token as TokenModel;

/**
* Token represents the model behind the search form about `my\test\common\models\Token`.
*/
class Token extends TokenModel
{
/**
* @inheritdoc
*/
public function rules()
{
return [
[['user_id', 'created_at', 'type'], 'integer'],
            [['code'], 'safe'],
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
$query = TokenModel::find();

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
            'user_id' => $this->user_id,
            'created_at' => $this->created_at,
            'type' => $this->type,
        ]);

        $query->andFilterWhere(['like', 'code', $this->code]);

return $dataProvider;
}
}