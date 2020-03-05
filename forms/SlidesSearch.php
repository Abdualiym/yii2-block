<?php

namespace abdualiym\block\forms;

use abdualiym\block\entities\Categories;
use abdualiym\block\entities\Slides;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class SlidesSearch extends Slides
{

    public function rules()
    {
        return [
            [['active'], 'integer'],
        ];
    }


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
    public function search($params, $slug)
    {
        $category = Categories::findOne(['slug' => $slug]);
        $query = Slides::find()->where(['category_id' => $category->id]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => [
                    'sort' => SORT_DESC
                ]
            ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere(['active' => $this->active]);

        return $dataProvider;
    }

}
