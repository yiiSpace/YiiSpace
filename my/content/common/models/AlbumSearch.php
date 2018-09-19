<?php

namespace my\content\common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use my\content\common\models\Album;

/**
* AlbumSearch represents the model behind the search form about `my\content\common\models\Album`.
*/
class AlbumSearch extends Album
{
/**
* @inheritdoc
*/
public function rules()
{
return [
[['id', 'owner_id', 'status', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['name', 'desc', 'keywords', 'cover_uri'], 'safe'],
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
$query = Album::find();

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
            'owner_id' => $this->owner_id,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'desc', $this->desc])
            ->andFilterWhere(['like', 'keywords', $this->keywords])
            ->andFilterWhere(['like', 'cover_uri', $this->cover_uri]);

return $dataProvider;
}
}