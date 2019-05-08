<?php

namespace abdualiym\text\forms;

use abdualiym\text\entities\Category;
use abdualiym\text\helpers\CategoryHelper;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;

class CategorySearch extends Model
{
    public $id;
//    public $title;
    public $status;

    public function rules()
    {
        return [
            [['id', 'status',], 'integer'],
//            [['title'], 'safe'],
        ];
    }

    /**
     * @param array $params
     * @return ActiveDataProvider
     */
    public function search(array $params): ActiveDataProvider
    {
        $query = Category::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => ['id' => SORT_DESC]
            ]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
        ]);

//        $query
//            ->andFilterWhere(['like', 'title', $this->title]);

        return $dataProvider;
    }

    public function statusList()
    {
        return CategoryHelper::statusList();
    }
}
