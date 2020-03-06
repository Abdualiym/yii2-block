<?php

use abdualiym\block\entities\Blocks;
use abdualiym\block\helpers\Type;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model Blocks */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="articles-form">

    <?php $form = ActiveForm::begin(); ?>
    <?= $form->field($model, 'category_id')->hiddenInput(['value' => $category->id])->label(false) ?>

    <?= $form->errorSummary($model) ?>

    <div class="box">
        <div class="box-body row">
            <div class="col-sm-2">
                <?= $form->field($model, 'type')->dropDownList(Type::list(), ['prompt' => '-- -- --']) ?>
            </div>
            <div class="col-sm-2">
                <?= $form->field($model, 'label')->textInput() ?>
            </div>
            <div class="col-sm-2">
                <?= $form->field($model, 'slug')->textInput() ?>
            </div>
            <div class="col-sm-2">
                <?php
                $model->size = $model->isNewRecord ? 6 : $model->size;
                echo $form->field($model, 'size')->textInput();
                ?>
            </div>
            <div class="col-sm-2">
                <?= $form->field($model, 'sort')->textInput(['value' => $model->getSortValue($category->id)]) ?>
            </div>
            <div class="col-sm-2">
                <br>
                <?= Html::submitButton(Yii::t('block', 'Save'), ['class' => 'btn btn-success btn-block']) ?>
            </div>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
