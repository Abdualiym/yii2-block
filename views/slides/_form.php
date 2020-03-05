<?php

use abdualiym\block\entities\Slides;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model Slides */
/* @var $form yii\widgets\ActiveForm */

$columnCount = 12 / count(Yii::$app->params['cms']['languages2']);
?>

<div class="articles-form">

    <?php $form = ActiveForm::begin(); ?>
    <?= $form->field($model, 'category_id')->hiddenInput(['value' => $category->id])->label(false) ?>

    <?= $form->errorSummary($model) ?>

    <div class="box">
        <div class="box-body row">
            <?php foreach (Yii::$app->params['cms']['languages2'] as $key => $language) : ?>
                <div class="col-sm-<?= $columnCount ?>">
                    <?php if (!$category->common_image || ($category->common_image && $key == 0)): ?>
                        <?= $form->field($model, 'photo_' . $key)->widget(\kartik\file\FileInput::class, [
                            'options' => ['accept' => 'image/*'],
                            'language' => Yii::$app->language,
                            'pluginOptions' => [
                                'showCaption' => false,
                                'showRemove' => false,
                                'showUpload' => false,
                                'browseClass' => 'btn btn-primary btn-block',
                                'browseLabel' => 'Рисунок',
                                'layoutTemplates' => [
                                    'main1' => '<div class="kv-upload-progress hide"></div>{remove}{cancel}{upload}{browse}{preview}',
                                ],
                                'initialPreview' => [
                                    Html::img($model->getThumbFileUrl('photo_' . $key, 'sm'), ['class' => 'file-preview-image', 'alt' => '', 'title' => '']),
                                ],
                            ],
                        ]);
                        ?>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>
    </div>


    <div class="box">
        <div class="box-header"><h2><?= Yii::t('block', 'Text') ?></h2></div>
        <div class="box-body row">
            <?php foreach (Yii::$app->params['cms']['languages2'] as $key => $language) : ?>
                <div class="col-sm-<?= $columnCount ?>">
                    <?php if (!$category->common_text || ($category->common_text && $key == 0)) : ?>
                        <?= $form->field($model, 'title_' . $key)->textInput(['maxlength' => true]) ?>
                        <?= $form->field($model, 'content_' . $key)->textarea(['rows' => 12]) ?>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>
    </div>


    <?php if ($category->use_tags) : ?>
        <div class="box">
            <div class="box-header"><h2><?= Yii::t('block', 'Tags') ?></h2></div>
            <div class="box-body">
                <?= $form->field($model, 'tags')->checkboxList($model->getTagsList())->label(false) ?>
            </div>
        </div>
    <?php endif; ?>


    <div class="box">
        <div class="box-header"><h2></h2></div>
        <div class="box-body">
            <div class="col-sm-2">
                <?= $form->field($model, 'sort')->textInput(['value' => $model->getSortValue($category->id)]) ?>
                <br>
                <?php
                $model->active = $model->isNewRecord;
                echo $form->field($model, 'active')->checkbox();
                ?>
                <?= Html::submitButton(Yii::t('block', 'Save'), ['class' => 'btn btn-success']) ?>
            </div>
            <?php foreach (Yii::$app->params['cms']['languages2'] as $key => $language) : ?>
                <div class="col-sm-2">
                    <?php if (!$category->common_link || ($category->common_link && $key == 0)) : ?>
                        <?= $form->field($model, 'link_' . $key)->textInput(['maxlength' => true]) ?>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
