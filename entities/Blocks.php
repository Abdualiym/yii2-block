<?php

namespace abdualiym\block\entities;

use abdualiym\block\helpers\Type;
use abdualiym\block\validators\SlugValidator;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\helpers\ArrayHelper;

/**
 * @property int $id
 * @property int $category_id
 * @property int $sort
 * @property int $size
 * @property string $label
 * @property string $slug
 * @property string $type
 * @property int $created_at
 * @property int $updated_at
 *
 * @property Categories $category
 */
class Blocks extends \yii\db\ActiveRecord
{

    public static function getBySlug($slug)
    {
        return Blocks::find()
            ->where(['category_id' => (Categories::findOne(['slug' => $slug]))->id])
            ->orderBy('sort')
            ->all();
    }

    public static function tableName()
    {
        return 'abdualiym_block_blocks';
    }

    public function rules()
    {
        return [
            [['category_id'], 'required'],
            [['category_id'], 'integer'],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Categories::class, 'targetAttribute' => ['category_id' => 'id']],

            [['sort'], 'required'],
            [['sort'], 'integer'],

            ['slug', 'required'],
            ['slug', 'string', 'max' => 255],
            ['slug', 'unique'],
            ['slug', SlugValidator::class],

            ['label', 'required'],
            ['label', 'string', 'max' => 255],

            ['size', 'required'],
            ['size', 'integer', 'min' => 1, 'max' => 12],

            ['type', 'required'],
            [['type'], 'in', 'range' => array_keys(Type::list())],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('block', 'ID'),
            'category_id' => Yii::t('block', 'Category'),
            'sort' => Yii::t('block', 'Sort'),
            'size' => Yii::t('block', 'Size'),
            'type' => Yii::t('block', 'Type'),
            'label' => Yii::t('block', 'Label'),
            'slug' => Yii::t('block', 'Slug'),
            'created_at' => Yii::t('block', 'Created At'),
            'updated_at' => Yii::t('block', 'Updated At'),
        ];
    }

    public function getSortValue($categoryId)
    {
        return $this->isNewRecord ? (self::find()->where(['category_id' => $categoryId])->max('sort') + 1) : $this->sort;
    }

    public function getCategory()
    {
        return $this->hasOne(Categories::class, ['id' => 'category_id']);
    }

    public function categoriesList()
    {
        return ArrayHelper::map(Categories::find()->asArray()->all(), 'id', 'title_0');
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::class,
        ];
    }

    public function getModelByType()
    {
        switch ($this->type) {
            case Type::FILES:
            case Type::FILE_COMMON:
                return File::findOne($this->id);
            case Type::IMAGES:
            case Type::IMAGE_COMMON:
                return Image::findOne($this->id);
            case Type::STRINGS:
            case Type::STRING_COMMON:
            case Type::TEXTS:
            case Type::TEXT_COMMON:
                return Text::findOne($this->id);
        }
    }
}
