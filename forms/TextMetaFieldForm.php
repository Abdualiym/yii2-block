<?php

namespace abdualiym\block\forms;

use abdualiym\block\entities\Text;
use abdualiym\block\entities\TextMetaFields;
use yii\base\Model;

/**
 * @property MetaForm $meta;
 */
class TextMetaFieldForm extends Model
{
    public $text_id;
    public $lang_id;
    public $key;
    public $value;

    public function __construct(TextMetaFields $meta = null, $config = [])
    {
        if ($meta) {
            $this->text_id = $meta->text_id;
            $this->lang_id = $meta->lang_id;
            $this->key = $meta->key;
            $this->value = $meta->value;
        }
        parent::__construct($config);
    }

    public function rules(): array
    {
        return [
            [['text_id', 'key', 'value'], 'required'],
            [['key'], 'string', 'max' => 255],
            [['value'], 'string'],
            [['lang_id'], 'integer'],
            ['text_id', 'exist', 'targetClass' => Text::class, 'targetAttribute' => 'id'],
//            ['key', 'unique', 'targetClass' => TextMetaFields::class, 'filter' => $this->key ? ['<>', 'key', $this->key] : null]
        ];
    }

    public function attributeLabels()
    {
        return [
            'lang_id' => 'Язык',
            'key' => 'Ключ',
            'value' => 'Значение',
        ];
    }
}