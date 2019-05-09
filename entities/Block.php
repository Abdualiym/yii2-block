<?php

namespace abdualiym\block\entities;

use abdualiym\block\helpers\Type;
use abdualiym\block\validators\SlugValidator;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

/**
 * @property integer $id
 * @property integer $parent_id
 * @property string $label
 * @property string $slug
 * @property integer $data_type
 * @property string $data_helper
 * @property boolean $common
 * @property string $data_0
 * @property string $data_1
 * @property string $data_2
 * @property string $data_3
 * @property integer $created_at
 * @property integer $updated_at
 */
class Block extends ActiveRecord
{

    public static function tableName(): string
    {
        return '{{%yii2_blocks}}';
    }

    ####################################

    public function rules(): array
    {
        return [
            [['label', 'slug', 'data_type'], 'required'],
            [['label', 'slug'], 'string', 'max' => 255],
            [['slug'], SlugValidator::class],
            [['data_type'], 'in', 'range' => array_keys(Type::list())],
            [['common'], 'boolean'],
            [['common'], 'default', 'value' => false],
            [['parent_id'], 'integer'],
            here
//            [['data_0', 'data_1', 'data_2','data_3'], 'string'],
//            [
//                ['data_helper'], 'image',
//                'when' => function (self $model) {
//                    return $model->data_type == Type::IMAGE;
//                }, 'enableClientValidation' => false
//            ],
//            [
//                ['data_helper'], 'file',
//                'when' => function (self $model) {
//                    return $model->data_type == Type::FILE;
//                }, 'enableClientValidation' => false
//            ],
//            [
//                ['data_helper'], 'url', 'defaultScheme' => 'http',
//                'when' => function (self $model) {
//                    return $model->data_type == Type::LINK;
//                }, 'enableClientValidation' => false
//            ],
        ];
    }


    ####################################

    public function parentList(): array
    {
        return ArrayHelper::map(Block::find()->where(['parent_id' => null])->asArray()->all(), 'id', 'label');
    }

    ####################################

    public function getParent(): ActiveQuery
    {
        return $this->hasOne(self::class, ['id' => 'parent_id']);
    }

    public function beforeDelete(): bool
    {
//        if (parent::beforeDelete()) {
//            foreach ($this->photos as $photo) {
//                $photo->delete();
//            }
//            return true;
//        }
        return false;
    }

    public function behaviors(): array
    {
        return array_merge(
            [TimestampBehavior::class],
            Type::config($this->data_type)
        );
    }


}