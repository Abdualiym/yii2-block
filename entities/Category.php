<?php

namespace abdualiym\block\entities;

use abdualiym\block\forms\CategoryForm;
use backend\entities\User;
use abdualiym\block\entities\queries\CategoryQuery;
use lhs\Yii2SaveRelationsBehavior\SaveRelationsBehavior;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yiidreamteam\upload\ImageUploadBehavior;

/**
 * @property integer $id
 * @property boolean $feed_with_image
 * @property integer $status
 * @property integer $created_at
 * @property integer $created_by
 * @property integer $updated_at
 * @property integer $updated_by
 *
 * @property CategoryTranslation[] $translations
 */
class Category extends ActiveRecord
{
    const STATUS_DRAFT = 0;
    const STATUS_ACTIVE = 1;

    const TEMPLATE_DEFAULT = 0;
    const TEMPLATE_WITHOUT_DATE = 1;
    const TEMPLATE_WITHOUT_LIST = 2;
    const TEMPLATE_GALLERY = 3;

    public $meta;

    public static function create($feed_with_image,$photo): self
    {
        $category = new static();
        $category->photo = $photo;
        $category->feed_with_image = $feed_with_image;
        $category->status = self::STATUS_DRAFT;
        return $category;
    }

    public function edit($feed_with_image,$photo)
    {
        $this->photo = $photo;
        $this->feed_with_image = $feed_with_image;
    }


    // Status

    public function activate()
    {
        if ($this->isActive()) {
            throw new \DomainException('Category is already active.');
        }
        $this->status = self::STATUS_ACTIVE;
    }

    public function draft()
    {
        if ($this->isDraft()) {
            throw new \DomainException('Category is already draft.');
        }
        $this->status = self::STATUS_DRAFT;
    }

    public function isActive(): bool
    {
        return $this->status == self::STATUS_ACTIVE;
    }

    public function isDraft(): bool
    {
        return $this->status == self::STATUS_DRAFT;
    }


    // Translations

    public function setTranslation($lang_id, $name, $title, $description, $meta)
    {
        $translations = $this->translations;
        foreach ($translations as $tr) {
            if ($tr->isForLanguage($lang_id)) {
                $tr->edit($name, $title, $description, $meta);
                $this->translations = $translations;
                return;
            }
        }
        $translations[] = CategoryTranslation::create($lang_id, $name, $title, $description, $meta);
        $this->translations = $translations;
    }

    public function getTranslation($id): CategoryTranslation
    {
        $translations = $this->translations;
        foreach ($translations as $tr) {
            if ($tr->isForLanguage($id)) {
                return $tr;
            }
        }
        return CategoryTranslation::blank($id);
    }


    ####################################

    public function getTranslations(): ActiveQuery
    {
        return $this->hasMany(CategoryTranslation::class, ['parent_id' => 'id']);
    }

    public function getCreatedBy(): ActiveQuery
    {
        return $this->hasOne(User::class, ['id' => 'created_by']);
    }

    public function getUpdatedBy(): ActiveQuery
    {
        return $this->hasOne(User::class, ['id' => 'updated_by']);
    }

    ####################################

    public function getTemplateTypes()
    {
        return CategoryForm::getTemplateTypes($this->feed_with_image);
    }


    ####################################

    public static function tableName(): string
    {
        return '{{%text_categories}}';
    }

    public function behaviors(): array
    {
        return [
            TimestampBehavior::class,
            BlameableBehavior::class,
            [
                'class' => SaveRelationsBehavior::class,
                'relations' => ['translations'],
            ],
            [
                'class' => ImageUploadBehavior::className(),
                'attribute' => 'photo',
                'createThumbsOnRequest' => true,
                'filePath' => '@staticRoot/app/category/[[id]].[[extension]]',
                'fileUrl' => '@staticUrl/app/category/[[id]].[[extension]]',
                'thumbPath' => '@staticRoot/app/cache/category/[[profile]]_[[id]].[[extension]]',
                'thumbUrl' => '@staticUrl/app/cache/category/[[profile]]_[[id]].[[extension]]',
                'thumbs' => [
                    'admin' => ['width' => 100, 'height' => 70],
                    'thumb' => ['width' => 480, 'height' => 480],
                ],
            ],
        ];
    }
    
}
