<?php

namespace abdualiym\block\forms;

use abdualiym\block\entities\TextTranslation;
use yii\base\Model;

/**
 * @property MetaForm $meta;
 */
class TextTranslationForm extends Model
{
    public $lang_id;
    public $title;
//    public $slug;
    public $description;
    public $content;
    public $meta;

    public function __construct(TextTranslation $translation = null, $config = [])
    {
        if ($translation) {
            $this->lang_id = $translation->lang_id;
            $this->title = $translation->title;
//            $this->slug = $translation->slug;
            $this->description = $translation->description;
            $this->content = $translation->content;
            $this->meta = 1;
        }
        parent::__construct($config);
    }

    public function rules(): array
    {
        return [
            [['title', 'lang_id'], 'required'],
            [['title'], 'string', 'max' => 255],
            [['description', 'content'], 'string'],
            [['meta'], 'default' , 'value' => 1],
//            ['slug', SlugValidator::class],
//            ['slug', 'unique', 'targetClass' => TextTranslation::class, 'filter' => $this->_textTranslation ? ['<>', 'id', $this->_textTranslation->id] : null]  // TODO  this may be resolve slug issue
        ];
    }

    public function attributeLabels()
    {
        return [
            'lang_id' => 'Язык',
            'title' => 'Название',
            'slug' => 'URL алиас',
            'description' => 'Описание',
            'content' => 'Контент',
        ];
    }

    public function internalForms(): array
    {
        return ['meta'];
    }
}