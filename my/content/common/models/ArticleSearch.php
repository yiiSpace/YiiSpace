<?php

namespace my\content\common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use my\content\common\models\Article;

/**
* ArticleSearch represents the model behind the search form about `my\content\common\models\Article`.
*/
class ArticleSearch extends Article
{
/**
* @inheritdoc
*/
public function rules()
{
return [
[['id', 'cate_id', 'display_order', 'view_count', 'status', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['title',  'intro', 'content', 'rep_thumb'], 'safe'],
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
$query = Article::find();

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
            'cate_id' => $this->cate_id,
            'display_order' => $this->display_order,
            'view_count' => $this->view_count,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
//            ->andFilterWhere(['like', 'title_alias', $this->title_alias])
            ->andFilterWhere(['like', 'intro', $this->intro])
            ->andFilterWhere(['like', 'content', $this->content])
            ->andFilterWhere(['like', 'rep_thumb', $this->rep_thumb]);

return $dataProvider;
}
}