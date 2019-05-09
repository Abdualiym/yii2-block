<?php

namespace abdualiym\block\entities;

use abdualiym\languageClass\Language;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\helpers\Html;

/**
 * @property integer $id
 * @property integer $text_id
 * @property integer $lang_id
 * @property string $key
 * @property string $value
 */
class TextMetaFields extends ActiveRecord
{
    public static function create($text_id, $lang_id, $key, $value): self
    {
        $meta = new static();
        $meta->text_id = $text_id;
        $meta->lang_id = $lang_id;
        $meta->key = $key;
        $meta->value = $value;
        return $meta;
    }

    public static function blank($lang_id): self
    {
        $meta = new static();
        $meta->lang_id = $lang_id;
        return $meta;
    }

    public function edit($text_id, $lang_id, $key, $value)
    {
        $this->text_id = $text_id;
        $this->lang_id = $lang_id;
        $this->key = $key;
        $this->value = $value;
    }

    //parametr key return value

    public function Value($text_id, $key, $lang = null)
    {
        if($model = $this->find()->where(['text_id'=> $text_id, 'key' => $key, 'lang_id' => $lang])->one()){
            return $model ? $model->value : '';
        }
    }
    ###########################

    public function isForLanguage($id): bool
    {
        return $this->lang_id == $id;
    }

    ##########################################################

    public function getText(): ActiveQuery
    {
        return $this->hasOne(Text::class, ['id' => 'text_id']);
    }

    ###########################################################

    public static function tableName(): string
    {
        return '{{%text_meta_fields}}';
    }

}