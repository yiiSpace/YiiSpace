<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Migration;

/**
 * MigrationSearch represents the model behind the search form about `common\models\Migration`.
 */
class MigrationSearch extends Migration
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['version'], 'safe'],
            [['apply_time'], 'integer'],
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
        $query = Migration::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'apply_time' => $this->apply_time,
        ]);

        $query->andFilterWhere(['like', 'version', $this->version]);

        return $dataProvider;
    }
}
