<?php

namespace abdualiym\text\forms;

use abdualiym\text\entities\Text;
use abdualiym\text\helpers\TextHelper;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class TextSearch extends Model
{
    public $id;
    public $title;
    public $status;
    public $category_id;
    public $date;
    public $page;

    public function __construct($page, array $config = [])
    {
        $this->page = $page;
        parent::__construct($config);
    }


    public function rules(): array
    {
        return [
            [['id', 'status'], 'integer'],
            [['title','category_id'], 'safe'],
        ];
    }

    /**
     * @param array $params
     * @return ActiveDataProvider
     */
    public function search(array $params): ActiveDataProvider
    {
        $query = Text::find()
            ->joinWith(['translations' => function ($q) {
                $q->andWhere(['lang_id' => 2]);
            }]);



        if ($this->page) {
            $query->andWhere(['is_article' => false]);
        } else {
            $query->andWhere(['is_article' => true]);
        }

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => ['id' => SORT_DESC]
            ],
            'pagination' => [
                'pageParam' => 'p',
                'pageSize' => 25
            ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
        ]);

        $query
            ->andFilterWhere(['like', 'text_text_translations.title', $this->title])
            ->andFilterWhere(['=', 'status', $this->status])
            ->andFilterWhere(['=', 'category_id', $this->category_id]);


        return $dataProvider;
    }

    public function statusList(): array
    {
        return TextHelper::statusList();
    }
}
