<?php

/* @var $this yii\web\View */
/* @var $model \abdualiym\block\entities\Block */

$this->title = $model->label;
$this->params['breadcrumbs'][] = ['label' => $model->label, 'url' => ['view', 'id' => $model->id]];

use kartik\file\FileInput;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$module = Yii::$app->controller->module;
?>

<div class="block-update">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>


    <div class="box box-default">
        <div class="box-header with-border">Обновить</div>
        <div class="box-body">

            <?= $form->errorSummary($model) ?>

            <?php if ($model->isCommon()): ?>
                <?php if ($model->isFile()): ?>
                    <?= $form->field($model, 'data_0')->widget(FileInput::class, [
                        'pluginOptions' => [
                            'initialPreview' => Html::img($model->getUploadedFileUrl('data_0'), ['class' => 'img-responsive']),
                            'overwriteInitial' => true
                        ],
                        'options' => ['accept' => 'image/*']
                    ])->label('Загрузить') ?>
                <?php else: ?>
                    <?= $form->field($model, 'data_0')->textInput(['maxlength' => true]) ?>
                <?php endif; ?>
            <?php else: ?>
                <ul class="nav nav-tabs" role="tablist">
                    <?php foreach ($module->languages as $key => $language) : ?>
                        <li role="presentation" <?= $key == 0 ? 'class="active"' : '' ?>>
                            <a href="#<?= $key ?>" aria-controls="<?= $key ?>" role="tab" data-toggle="tab"><?= $language ?></a>
                        </li>
                    <?php endforeach; ?>
                </ul>
                <div class="tab-content">
                    <br>
                    <?php foreach ($module->languages as $key => $language) : ?>
                        <div role="tabpanel" class="tab-pane <?= $key == 0 ? 'active' : '' ?>" id="<?= $key ?>">
                            <?= $form->field($model, 'data_' . $key)->widget(FileInput::class, [
                                'pluginOptions' => [
                                    'initialPreview' => Html::img($model->getUploadedFileUrl('data_' . $key), ['class' => 'img-responsive']),
                                    'overwriteInitial' => true
                                ],
                                'options' => ['accept' => 'image/*']
                            ])->label('Загрузить') ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>