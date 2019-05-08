<?php

namespace abdualiym\text\forms;

use abdualiym\text\entities\TextMetaFields;
use abdualiym\text\helpers\TextHelper;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class TextMetaFiledSearch extends Model
{
    public $lang_id;
    public $key;
    public $value;
    public $text_id;

    public function __construct($id, array $config = [])
    {
        parent::__construct($config);
        $this->text_id = $id;
    }

    public function rules(): array
    {
        return [
            [['lang_id'], 'integer'],
            [['key', 'value'], 'safe'],
        ];
    }

    /**
     * @param array $params
     * @return ActiveDataProvider
     */
    public function search(array $params): ActiveDataProvider
    {
        $query = TextMetaFields::find()->where(['text_id' => $this->text_id]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => ['key' => SORT_DESC]
            ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'lang_id' => $this->lang_id,
        ]);

        $query
            ->andFilterWhere(['like', 'key', $this->key])
            ->andFilterWhere(['like', 'value', $this->value]);

        return $dataProvider;
    }

    public function statusList(): array
    {
        return TextHelper::statusList();
    }
}
