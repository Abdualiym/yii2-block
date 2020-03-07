<?php

namespace abdualiym\block\entities;

use kartik\file\FileInput;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\helpers\Html;
use yii\web\UploadedFile;
use yiidreamteam\upload\FileUploadBehavior;

/**
 * @property int $id
 * @property int $created_at
 * @property int $updated_at
 */
class File extends BlockActiveRecord
{

    public function rules()
    {
        return [
            [['data_0', 'data_1', 'data_2', 'data_3'], 'file']
        ];
    }

    public function attributeLabels()
    {
        $language0 = Yii::$app->params['cms']['languages2'][0] ?? '';
        $language1 = Yii::$app->params['cms']['languages2'][1] ?? '';
        $language2 = Yii::$app->params['cms']['languages2'][2] ?? '';
        $language3 = Yii::$app->params['cms']['languages2'][3] ?? '';

        return [
            'data_0' => Yii::t('slider', 'File') . '(' . $language0 . ')',
            'data_1' => Yii::t('slider', 'File') . '(' . $language1 . ')',
            'data_2' => Yii::t('slider', 'File') . '(' . $language2 . ')',
            'data_3' => Yii::t('slider', 'File') . '(' . $language3 . ')',
        ];
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::class,
            $this->getBehaviorConfig('data_0'),
            $this->getBehaviorConfig('data_1'),
            $this->getBehaviorConfig('data_2'),
            $this->getBehaviorConfig('data_3')
        ];
    }

    private function getBehaviorConfig($attribute)
    {
        $module = Yii::$app->getModule('block');

        return [
            'class' => FileUploadBehavior::class,
            'attribute' => $attribute,
            'filePath' => $module->storageRoot . '/data/blocks/[[attribute_id]]/[[filename]].[[extension]]',
            'fileUrl' => $module->storageHost . '/data/blocks/[[attribute_id]]/[[filename]].[[extension]]'
        ];
    }

    public function getData($key)
    {
        return $this->getUploadedFileUrl('data_' . $key) . 'file';
    }

    public function getFormField($form, $key, $language)
    {
        return $form->field($this, '[' . $this->id . ']data_' . $key)->widget(FileInput::class, [ // TODO use form array and key is BLOCK_ID
            'options' => ['accept' => '*'],
            'language' => Yii::$app->language,
            'pluginOptions' => [
                'showPreview' => true,
                'showCaption' => false,
                'showRemove' => false,
                'showCancel' => false,
                'showUpload' => false,
                'previewFileType' => 'any',
                'browseClass' => 'btn btn-primary btn-block',
                'browseLabel' => Yii::t('block', 'Upload'),
                'layoutTemplates' => [
                    'main1' => '<div class="kv-upload-progress hide"></div>{browse}{preview}',
                ],
                'initialPreview' => [
                    Html::a($this->{'data_' . $key}, $this->getUploadedFileUrl('data_' . $key), ['target' => '_blank'])
                ],
            ],
        ])->label($this->label . "($language)");
    }

    public function beforeValidate()
    {
        $this->data_0 = UploadedFile::getInstanceByName(Html::getInputName($this, '[' . $this->id . ']data_0'));
        $this->data_1 = UploadedFile::getInstanceByName(Html::getInputName($this, '[' . $this->id . ']data_1'));
        $this->data_2 = UploadedFile::getInstanceByName(Html::getInputName($this, '[' . $this->id . ']data_2'));
        $this->data_3 = UploadedFile::getInstanceByName(Html::getInputName($this, '[' . $this->id . ']data_3'));
        return parent::beforeValidate();
    }
}
