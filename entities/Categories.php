<?php

namespace abdualiym\block\entities;

use abdualiym\block\validators\SlugValidator;
use abdualiym\language\Language;
use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * @property int $id
 * @property string $slug
 * @property string $title
 * @property int $created_at
 * @property int $updated_at
 */
class Categories extends \yii\db\ActiveRecord
{

    public static function tableName()
    {
        return 'abdualiym_block_categories';
    }

    public function rules()
    {
        return [
            ['slug', 'required'],
            [['slug'], 'unique'],
            [['slug'], 'string', 'max' => 30],
            [['slug'], SlugValidator::class],

            ['title', 'required'],
            [['title'], 'string', 'max' => 255],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => Yii::t('block', 'ID'),
            'slug' => Yii::t('block', 'Slug'),
            'title' => Yii::t('block', 'Title'),
            'created_at' => Yii::t('block', 'Created At'),
            'updated_at' => Yii::t('block', 'Updated At'),
        ];
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::class,
        ];
    }
}
