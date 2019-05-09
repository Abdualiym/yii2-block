<?php

namespace abdualiym\block\forms;

use abdualiym\block\entities\Block;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class BlockSearch extends Model
{
    public $id;
    public $title;
    public $status;
    public $category_id;
    public $date;

    public function __construct(array $config = [])
    {
        parent::__construct($config);
    }


    public function rules(): array
    {
        return [
            [['id', 'status'], 'integer'],
            [['title', 'category_id'], 'safe'],
        ];
    }

    /**
     * @param array $params
     * @return ActiveDataProvider
     */
    public function search(array $params): ActiveDataProvider
    {
        $query = Block::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
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
//            ->andFilterWhere(['like', 'text_text_translations.title', $this->title])
            ->andFilterWhere(['=', 'status', $this->status])
            ->andFilterWhere(['=', 'category_id', $this->category_id]);

        return $dataProvider;
    }
}
