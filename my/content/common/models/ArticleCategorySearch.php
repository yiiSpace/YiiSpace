<?php

namespace my\content\common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use my\content\common\models\ArticleCategory;

/**
* ArticleCategorySearch represents the model behind the search form about `my\content\common\models\ArticleCategory`.
*/
class ArticleCategorySearch extends ArticleCategory
{
/**
* @inheritdoc
*/
public function rules()
{
return [
[['id', 'parent_id', 'display_order', 'mbr_count', 'page_size', 'status', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['name', 'redirect_url'], 'safe'],
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
$query = ArticleCategory::find();

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
            'parent_id' => $this->parent_id,
            'display_order' => $this->display_order,
            'mbr_count' => $this->mbr_count,
            'page_size' => $this->page_size,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'redirect_url', $this->redirect_url]);

return $dataProvider;
}
}