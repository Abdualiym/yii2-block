<?php

namespace abdualiym\block\entities;

use Yii;
use yii\base\Exception;
use yii\behaviors\TimestampBehavior;
use yii\helpers\ArrayHelper;
use yiidreamteam\upload\ImageUploadBehavior;

/**
 * @property int $id
 * @property int $category_id
 * @property int $active
 * @property int $sort
 * @property string $photo_0
 * @property string $photo_1
 * @property string $photo_2
 * @property string $photo_3
 * @property string $link_0
 * @property string $link_1
 * @property string $link_2
 * @property string $link_3
 * @property string $title_0
 * @property string $title_1
 * @property string $title_2
 * @property string $title_3
 * @property string $content_0
 * @property string $content_1
 * @property string $content_2
 * @property string $content_3
 * @property int $created_at
 * @property int $updated_at
 *
 * @property Categories $category
 * @property Tags $tags
 */
class Slides extends \yii\db\ActiveRecord
{
    public $tags;

    public static function getBySlug($slug, $count = false)
    {
        $slidesQuery = Slides::find()->where(['category_id' => (Categories::findOne(['slug' => $slug]))->id]);
        return $count ? $slidesQuery->count() : $slidesQuery->orderBy('sort')->all();
    }

    public static function tableName()
    {
        return 'abdualiym_slider_slides';
    }

    public function rules()
    {
        return [
            [['category_id'], 'required'],
            [['category_id'], 'integer'],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Categories::class, 'targetAttribute' => ['category_id' => 'id']],

            [['active'], 'boolean'],
            [['active'], 'default', 'value' => true],

            [['sort'], 'required'],
            [['sort'], 'integer'],

            [['photo_0', 'photo_1', 'photo_2', 'photo_3'], 'image'],

            [['link_0', 'link_1', 'link_2', 'link_3'], 'url', 'defaultScheme' => 'http'],

            [['title_0', 'title_1', 'title_2', 'title_3'], 'string', 'max' => 255],

            [['content_0', 'content_1', 'content_2', 'content_3'], 'string'],

            ['tags', 'each', 'rule' => ['integer']]
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        $language0 = Yii::$app->params['cms']['languages2'][0] ?? '';
        $language1 = Yii::$app->params['cms']['languages2'][1] ?? '';
        $language2 = Yii::$app->params['cms']['languages2'][2] ?? '';
        $language3 = Yii::$app->params['cms']['languages2'][3] ?? '';

        return [
            'id' => Yii::t('block', 'ID'),
            'category_id' => Yii::t('block', 'Category'),
            'active' => Yii::t('block', 'Active'),
            'sort' => Yii::t('block', 'Sort'),
            'photo_0' => Yii::t('block', 'Photo') . '(' . $language0 . ')',
            'photo_1' => Yii::t('block', 'Photo') . '(' . $language1 . ')',
            'photo_2' => Yii::t('block', 'Photo') . '(' . $language2 . ')',
            'photo_3' => Yii::t('block', 'Photo') . '(' . $language3 . ')',
            'link_0' => Yii::t('block', 'Link') . '(' . $language0 . ')',
            'link_1' => Yii::t('block', 'Link') . '(' . $language1 . ')',
            'link_2' => Yii::t('block', 'Link') . '(' . $language2 . ')',
            'link_3' => Yii::t('block', 'Link') . '(' . $language3 . ')',
            'title_0' => Yii::t('block', 'Title') . '(' . $language0 . ')',
            'title_1' => Yii::t('block', 'Title') . '(' . $language1 . ')',
            'title_2' => Yii::t('block', 'Title') . '(' . $language2 . ')',
            'title_3' => Yii::t('block', 'Title') . '(' . $language3 . ')',
            'content_0' => Yii::t('block', 'Content') . '(' . $language0 . ')',
            'content_1' => Yii::t('block', 'Content') . '(' . $language1 . ')',
            'content_2' => Yii::t('block', 'Content') . '(' . $language2 . ')',
            'content_3' => Yii::t('block', 'Content') . '(' . $language3 . ')',
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
            $this->getImageUploadBehaviorConfig('photo_0'),
            $this->getImageUploadBehaviorConfig('photo_1'),
            $this->getImageUploadBehaviorConfig('photo_2'),
            $this->getImageUploadBehaviorConfig('photo_3'),
        ];
    }

    private function getImageUploadBehaviorConfig($attribute)
    {
        $module = Yii::$app->getModule('slider');

        return [
            'class' => ImageUploadBehavior::class,
            'attribute' => $attribute,
            'createThumbsOnRequest' => true,
            'filePath' => $module->storageRoot . '/data/articles/[[attribute_id]]/[[filename]].[[extension]]',
            'fileUrl' => $module->storageHost . '/data/articles/[[attribute_id]]/[[filename]].[[extension]]',
            'thumbPath' => $module->storageRoot . '/cache/articles/[[attribute_id]]/[[profile]]_[[filename]].[[extension]]',
            'thumbUrl' => $module->storageHost . '/cache/articles/[[attribute_id]]/[[profile]]_[[filename]].[[extension]]',
            'thumbs' => array_merge($module->thumbs, [
                'sm' => ['width' => 106, 'height' => 60],
                'md' => ['width' => 212, 'height' => 120],
            ])
        ];
    }

    public function getTagsList($ownTags = false)
    {
        $tagsQuery = Tags::find()->select(['title_0', 'id'])->indexBy('id');
        if ($ownTags) {
            $tagIds = SlideTags::find()->where(['slide_id' => $this->id])->select('tag_id')->column();
            $tagsQuery->where(['id' => $tagIds]);
        }

        return $tagsQuery->column();
    }

    public function beforeSave($insert)
    {
        if (!parent::beforeSave($insert)) {
            return false;
        }

        try {
            SlideTags::deleteAll(['slide_id' => $this->id]);
            if (is_array($this->tags)) {
                foreach ($this->tags as $tagId) {
                    $tagsModel = new SlideTags();
                    $tagsModel->tag_id = $tagId;
                    $tagsModel->slide_id = $this->id;
                    $tagsModel->save();
                }
            }
            return true;
        } catch (Exception $e) {
            Yii::$app->session->setFlash('error', $e->getMessage());
        }
    }

    public function afterFind()
    {
        parent::afterFind();
        $this->tags = SlideTags::find()->select('tag_id')->where(['slide_id' => $this->id])->column();
    }
}
