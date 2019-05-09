<?php

namespace abdualiym\block\forms;

use abdualiym\languageClass\Language;
use abdualiym\block\entities\Category;
use elisdn\compositeForm\CompositeForm;
use yii\helpers\Html;
use yii\helpers\VarDumper;
use yii\web\UploadedFile;

/**
 * @property CategoryTranslationForm $translations
 */
class CategoryForm extends CompositeForm
{
    public $feed_with_image;
    public $photo;
    private $_category;

    public function __construct(Category $category = null, $config = [])
    {
        if ($category) {
            $this->feed_with_image = $category->feed_with_image;
            $this->translations = array_map(function (array $language) use ($category) {
                return new CategoryTranslationForm($category->getTranslation($language['id']));
            }, Language::langList(\Yii::$app->params['languages']));
            $this->_category = $category;
        } else {
            $this->translations = array_map(function () {
                return new CategoryTranslationForm();
            }, Language::langList(\Yii::$app->params['languages']));
        }
        parent::__construct($config);
    }

    public function rules()
    {
        return [
            [['feed_with_image'], 'required'],
            [['feed_with_image'], 'integer'],
            ['photo', 'image'],
        ];
    }

    public function beforeValidate(): bool
    {
        if (parent::beforeValidate()) {
            $this->photo = UploadedFile::getInstance($this, 'photo');
            return true;
        }

        return false;
    }


    public function attributeLabels()
    {
        return [
            'feed_with_image' => 'Выберите шаблон',
            'created_at' => 'Дата добавления',
            'updated_at' => 'Дата обновления',
            'created_by' => 'Добавил',
            'updated_by' => 'Обновил',
        ];
    }

    public static function getTemplateTypes($id = null)
    {
        $types = [
            Category::TEMPLATE_DEFAULT => [
                'title' => 'по умолчанию',
                'img' => Html::img('/img/templates/0.jpg', ['class' => 'img-responsive img-radio','style' => 'max-width:150px;'])
                    . Html::button('по умолчанию', ['class' => 'btn btn-primary btn-radio btn-flat'])
            ],
            Category::TEMPLATE_WITHOUT_DATE => [
                'title' => 'без даты',
                'img' => Html::img('/img/templates/1.jpg', ['class' => 'img-responsive img-radio', 'style' => 'max-width:150px;'])
                    . Html::button('без даты', ['class' => 'btn btn-primary btn-radio btn-flat'])
            ],
            Category::TEMPLATE_WITHOUT_LIST => [
                'title' => 'без списка',
                'img' => Html::img('/img/templates/2.jpg', ['class' => 'img-responsive img-radio', 'style' => 'max-width:150px;'])
                    . Html::button('без списка', ['class' => 'btn btn-primary btn-radio btn-flat'])
            ],
            Category::TEMPLATE_GALLERY => [
                'title' => 'Галерея',
                'img' => Html::img('/img/templates/3.jpg', ['class' => 'img-responsive img-radio', 'style' => 'max-width:150px;'])
                    . Html::button('Галерея', ['class' => 'btn btn-primary btn-radio btn-flat'])
            ],
        ];

        return $id ? $types[$id] : $types;
    }


    public function internalForms()
    {
        return ['translations'];
    }
}