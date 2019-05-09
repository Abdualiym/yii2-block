<?php

use abdualiym\languageClass\Language;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */
/* @var $model abdualiym\text\forms\TextForm */
/* @var $text abdualiym\text\entities\Text */

$langList = Language::langList(Yii::$app->params['languages'], true);

foreach ($model->translations as $i => $translation) {
    if (!$translation->lang_id) {
        $q = 0;
        foreach ($langList as $k => $l) {
            if ($i == $q) {
                $translation->lang_id = $k;
            }
            $q++;
        }
    }
}
$thumb = isset($text->photo) ? $text->getThumbFileUrl('photo', 'thumb') : '';
?>

<div class="text-form">

    <?php $form = ActiveForm::begin([
        'options' => ['enctype' => 'multipart/form-data']
    ]); ?>

    <div class="row">
        <div class="col-md-9">

            <div class="box box-default">
                <div class="box-body">
                    <?= $form->errorSummary($model) ?>
                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs" role="tablist">
                        <?php
                        foreach ($model->translations as $i => $translation) {
                            ?>
                            <li role="presentation" <?= $i == 0 ? 'class="active"' : '' ?>>
                                <a href="#<?= $langList[$translation->lang_id]['prefix'] ?>"
                                   aria-controls="<?= $langList[$translation->lang_id]['prefix'] ?>" role="tab" data-toggle="tab">
                                    <?= '(' . $langList[$translation->lang_id]['prefix'] . ') ' . $langList[$translation->lang_id]['title'] ?>
                                </a>
                            </li>
                        <?php } ?>
                    </ul>

                    <!-- Tab panes -->
                    <div class="tab-content">
                        <br>
                        <?php foreach ($model->translations as $i => $translation): ?>
                            <div role="tabpanel" class="tab-pane <?= $i == 0 ? 'active' : '' ?>"
                                 id="<?= $langList[$translation->lang_id]['prefix'] ?>">
                                <?= $form->field($translation, '[' . $i . ']title')->textInput(['maxlength' => true])->label("Название на (" . $langList[$translation->lang_id]['title'] . ")") ?>
                                <?php //= $form->field($model->translations, 'slug[' . $i . ']')->textInput(['maxlength' => true, 'value' => ($translation != '') ? $translation[$i]['slug'] : $translation]) ?>
                                <?= $form->field($translation, '[' . $i . ']description')->textarea() ?>
                                <?= $form->field($translation, '[' . $i . ']content')->widget(\mihaildev\ckeditor\CKEditor::class); ?>
                                <?= $form->field($translation, '[' . $i . ']lang_id')->hiddenInput(['value' => $translation->lang_id])->label(false) ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="box box-default">
                <div class="box-header with-border">Общие настройки</div>
                <div class="box-body">
                    <?= $form->field($model, 'category_id')->dropDownList($model->categoriesList(true), ['prompt' => 'No category'])->label('Категория') ?>
                    <div class="<?= $page ? 'hidden' : '' ?>">
                        <?php $model->date = $model->date ?: date('d.m.Y') ?>
                        <?= $form->field($model, 'date')->widget(\yii\jui\DatePicker::classname(), [
                            'dateFormat' => 'd.MM.yyyy',
                            'clientOptions' => [
                                // 'showButtonPanel'=>true,
                                'changeYear' => true,
                                'defaultDate' => date('Y-m-d')
                            ],
                            'options' => ['class' => 'form-control']
//                    ])->label(Yii::t('block', 'Date'))
                        ])->label('Дата публикаций') ?>
                    </div>

                    <?= Html::submitButton(Html::tag('i','',['class'=>'fa fa-save']) . ' Сохранить', ['class' => 'btn btn-success btn-block btn-flat']) ?>
                </div>
            </div>

            <?php if (!isset($text)): ?>
                <div class="box" id="photos">
                    <div class="box-header with-border">Фотографий</div>
                    <div class="box-body">
                        <?= $form->field($model->photos, 'files[]')->widget(\kartik\file\FileInput::class, [
                            'options' => [
                                'accept' => 'image/*',
                                'multiple' => true,
                            ]
                        ])->label('Загрузить фотографий') ?>
                    </div>
                </div>
            <?php endif; ?>


        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
