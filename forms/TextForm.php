<?php

namespace abdualiym\block\forms;

use abdualiym\block\entities\Category;
use abdualiym\block\entities\Text;
use yii\base\Model;
use yii\helpers\ArrayHelper;
use yii\web\UploadedFile;

/**
 * @property TextTranslationForm $translations
 * @property PhotosForm $photos
 */
class TextForm extends Model
{
    public $category_id;
    public $date;
    private $_text;

    public function __construct(Text $text = null, $config = [])
    {
        if ($text) {
            $this->category_id = $text->category_id;
            $this->date = $text->date;
            $this->_text = $text;
        }

        parent::__construct($config);
    }

    public function rules(): array
    {
        return [
            [['date'], 'required'],
            [['category_id'], 'integer'],
            [['date'], 'string', 'max' => 12],
        ];
    }

    public function categoriesList($lang = false): array
    {
        return ArrayHelper::map(
            Category::find()->where(['status' => Category::STATUS_ACTIVE])->with('translations')->asArray()->all(), 'id', function (array $category) use ($lang) {
            return $lang ? $category['translations'][0]['name'] : $category['translations'];
        });
    }

    public function textsList($lang = false): array
    {
        return ArrayHelper::map(
            Text::find()->where(['status' => Text::STATUS_ACTIVE])->with('translations')->asArray()->all(), 'id', function (array $text) use ($lang) {
            return $lang ? $text['translations'][0]['title'] : $text['translations'];
        });
    }
}