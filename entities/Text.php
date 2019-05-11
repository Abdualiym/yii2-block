<?php

namespace abdualiym\block\entities;

use abdualiym\languageClass\Language;
use abdualiym\block\helpers\TextHelper;
use backend\entities\User;
use domain\modules\menu\entities\Menu;
use abdualiym\block\entities\queries\TextQuery;
use lhs\Yii2SaveRelationsBehavior\SaveRelationsBehavior;
use yii\behaviors\AttributeBehavior;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\VarDumper;
use yii\web\UploadedFile;
use yiidreamteam\upload\ImageUploadBehavior;

/**
 * @property integer $id
 * @property integer $category_id
 * @property boolean $is_article
 * @property integer $status
 * @property integer $date
 * @property integer $views_count
 * @property integer $created_at
 * @property integer $created_by
 * @property integer $updated_at
 * @property integer $updated_by
 *
 * @property TextTranslation[] $translations
 * @property Photo[] $photos
 */
class Text extends ActiveRecord
{
    const STATUS_DRAFT = 0;
    const STATUS_ACTIVE = 1;

    public static function create($category_id, $date): self
    {
        $text = new static();
        $text->category_id = $category_id;
        $text->date = $date;
        $text->status = self::STATUS_DRAFT;
        return $text;
    }

    public function edit($category_id, $date)
    {
        $this->category_id = $category_id;
        $this->date = $date;
    }



    // Photos

    public function addPhoto(UploadedFile $file)
    {
        $photos = $this->photos;
        $photos[] = Photo::create($file);
        $this->updatePhotos($photos);
    }

    public function removePhoto($id)
    {
        $photos = $this->photos;
        foreach ($photos as $i => $photo) {
            if ($photo->isIdEqualTo($id)) {
                unset($photos[$i]);
                $this->updatePhotos($photos);
                return;
            }
        }
        throw new \DomainException('Photo is not found.');
    }

    public function removePhotos()
    {
        $this->updatePhotos([]);
    }

    public function movePhotoUp($id)
    {
        $photos = $this->photos;
        foreach ($photos as $i => $photo) {
            if ($photo->isIdEqualTo($id)) {
                if ($prev = $photos[$i - 1] ?? null) {
                    $photos[$i - 1] = $photo;
                    $photos[$i] = $prev;
                    $this->updatePhotos($photos);
                }
                return;
            }
        }
        throw new \DomainException('Photo is not found.');
    }

    public function movePhotoDown($id)
    {
        $photos = $this->photos;
        foreach ($photos as $i => $photo) {
            if ($photo->isIdEqualTo($id)) {
                if ($next = $photos[$i + 1] ?? null) {
                    $photos[$i] = $next;
                    $photos[$i + 1] = $photo;
                    $this->updatePhotos($photos);
                }
                return;
            }
        }
        throw new \DomainException('Photo is not found.');
    }

    private function updatePhotos(array $photos)
    {
        foreach ($photos as $i => $photo) {
            $photo->setSort($i);
        }
        $this->photos = $photos;
        $this->populateRelation('mainPhoto', reset($photos));
    }

    // Translations

    public function setTranslation($lang_id, $title, $description, $content, $meta)
    {
        $translations = $this->translations;
        foreach ($translations as $tr) {
            if ($tr->isForLanguage($lang_id)) {
                $tr->edit($title, $description, $content, $meta);
                $this->translations = $translations;
                return;
            }
        }
        $translations[] = TextTranslation::create($lang_id, $title, $description, $content, $meta);
        $this->translations = $translations;
    }

    public function getTranslation($id): TextTranslation
    {
        $translations = $this->translations;
        foreach ($translations as $tr) {
            if ($tr->isForLanguage($id)) {
                return $tr;
            }
        }
        return TextTranslation::blank($id);
    }


    ####################################

    public function getTranslations(): ActiveQuery
    {
        return $this->hasMany(TextTranslation::class, ['parent_id' => 'id']);
    }

    public function getMetaFields(): ActiveQuery
    {
        return $this->hasMany(TextMetaFields::class, ['text_id' => 'id']);
    }

    public function getCategory(): ActiveQuery
    {
        return $this->hasOne(Category::class, ['id' => 'category_id']);
    }

    public function getCreatedBy(): ActiveQuery
    {
        return $this->hasOne(User::class, ['id' => 'created_by']);
    }

    public function getUpdatedBy(): ActiveQuery
    {
        return $this->hasOne(User::class, ['id' => 'updated_by']);
    }

    public function getPhotos(): ActiveQuery
    {
        return $this->hasMany(Photo::class, ['text_id' => 'id'])->orderBy('sort');
    }

    public function getMainPhoto(): ActiveQuery
    {
        return $this->hasOne(Photo::class, ['id' => 'main_photo_id']);
    }

    ####################################

    public static function tableName(): string
    {
        return '{{%text_texts}}';
    }

    public function behaviors(): array
    {
        return [
            TimestampBehavior::class,
            BlameableBehavior::class,
            [
                'class' => AttributeBehavior::class,
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['date'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['date'],
                ],
                'value' => function () {
                    return is_integer($this->date) ? $this->date : (int)strtotime($this->date);
                },
            ],
            [
                'class' => AttributeBehavior::class,
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['is_article'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['is_article'],
                ],
                'value' => function () {
                    return $this->category_id ? true : false;
                },
            ],
            [
                'class' => SaveRelationsBehavior::class,
                'relations' => ['translations', 'photos'],
            ],
        ];
    }

    public function transactions(): array
    {
        return [
            self::SCENARIO_DEFAULT => self::OP_ALL,
        ];
    }

    public function beforeDelete(): bool
    {
        if (parent::beforeDelete()) {
            foreach ($this->photos as $photo) {
                $photo->delete();
            }
            return true;
        }
        return false;
    }


    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);

        $related = $this->getRelatedRecords();
        if (array_key_exists('mainPhoto', $related)) {
            $this->updateAttributes(['main_photo_id' => $related['mainPhoto'] ? $related['mainPhoto']->id : null]);
        }

        $content = '';
        foreach ($this->translations as $translation) {
            $content .= '<br>Заголовок: <br>' . $translation->title;
            $content .= '<br>Описание: <br>' . $translation->description;
            $content .= '<br>Контент: <br>' . $translation->content;
        }

        ContentHistory::log(
            '<b>TextID=' . $this->id . ' был ' . ($insert ? 'добавлен' : 'обновлен') . '</b>'
            . '<br>дата: ' . date('d m Y', $this->date)
            . '<br>статус: ' . TextHelper::statusName($this->status)
            . '<br>тип: ' . ($this->is_article ? 'статья' : 'страница')
            . '<br>категория: ' . ($this->category_id ?: 'нет')
            . '<br>' . $content
        );
    }


    public function afterDelete()
    {
        parent::afterDelete();
        ContentHistory::log('<b>TextID=' . $this->id . ' был удален.</b>');
    }


    public static function find(): TextQuery
    {
        return new TextQuery(static::class);
    }
}