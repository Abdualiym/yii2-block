<?php

namespace abdualiym\block\forms;

use abdualiym\languageClass\Language;
use abdualiym\block\entities\CategoryTranslation;
use yii\base\Model;

/**
 * @property MetaForm $meta;
 */
class CategoryTranslationForm extends Model
{
    public $lang_id;
    public $name;
//    public $slug;
    public $title;
    public $description;
    public $meta;

    public function __construct(CategoryTranslation $translation = null, $config = [])
    {
        if ($translation) {
            $this->lang_id = $translation->lang_id;
            $this->name = $translation->name;
//            $this->slug = $categoryTranslation->slug;
            $this->title = $translation->title;
            $this->description = $translation->description;
//            $this->meta = new MetaForm($categoryTranslation->meta);
            $this->meta = 1;
        }
        parent::__construct($config);
    }

    public function rules(): array
    {
        return [
            [['name', 'lang_id'], 'required'],
            [['name', 'title'], 'string', 'max' => 255],
            [['description'], 'string'],
            [['meta'], 'default', 'value' => 1],
//            ['slug', SlugValidator::class],
//            ['slug', 'unique', 'targetClass' => CategoryTranslation::class, 'filter' => $this->_translation ? ['<>', 'id', $this->_translation->id] : null]
        ];
    }

    public function attributeLabels()
    {
        return [
            'lang_id' => 'Язык',
            'name' => 'Название',
            'slug' => 'URL алиас',
            'title' => 'Заглавие',
            'description' => 'Описание',
        ];
    }

//    public function getId(): int
//    {
//        return $this->_language->id;
//    }

    public function internalForms(): array
    {
        return ['meta'];
    }
}