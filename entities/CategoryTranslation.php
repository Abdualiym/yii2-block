<?php

namespace abdualiym\block\entities;

use yii\db\ActiveRecord;
use yii\helpers\Json;

/**
 * @property integer $id
 * @property integer $lang_id
 * @property string $name
 * @property string $slug
 * @property string $title
 * @property string $description
 * @property Meta $meta
 */
class CategoryTranslation extends ActiveRecord
{
//    public $meta;

    public static function create($lang_id, $name, $title, $description, $meta): self
    {
        $translation = new static();
        $translation->lang_id = $lang_id;
        $translation->name = $name;
//        $translation->slug = $slug;
        $translation->title = $title;
        $translation->description = $description;
        $translation->meta_json = Json::encode(1);
        return $translation;
    }

    public static function blank($lang_id): self
    {
        $translation = new static();
        $translation->lang_id = $lang_id;
        return $translation;
    }

    public function edit($name, $title, $description, $meta)
    {
        $this->name = $name;
//        $this->slug = $slug;
        $this->title = $title;
        $this->description = $description;
        $this->meta_json = Json::encode(1);
    }

    ###########################

    public function isForLanguage($id): bool
    {
        return $this->lang_id == $id;
    }

    ##########################################################

    public function getCategory()
    {
        return $this->hasOne(Category::class, ['id' => 'parent_id']);
    }

    ###########################################################

    public static function tableName(): string
    {
        return '{{%text_category_translations}}';
    }




    public function behaviors()
    {
        return [
            'slug' => [
                'class' => 'Zelenin\yii\behaviors\Slug',
                'slugAttribute' => 'slug',
                'attribute' => 'name',
                // optional params
                'ensureUnique' => true,
                'replacement' => '-',
                'lowercase' => true,
                'immutable' => false,
                // If intl extension is enabled, see http://userguide.icu-project.org/transforms/general.
                'transliterateOptions' => 'Russian-Latin/BGN; Any-Latin; Latin-ASCII; NFD; [:Nonspacing Mark:] Remove; NFC;'
            ]
        ];
    }

}