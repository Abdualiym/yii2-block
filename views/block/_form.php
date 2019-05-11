<?php

use abdualiym\block\helpers\Type;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */
/* @var $block \abdualiym\block\entities\Block */
?>

<div class="block-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="box box-default">
        <div class="box-body">
            <?= $form->errorSummary($model) ?>
            <?= $form->field($model, 'parent_id')->dropDownList($model::parentList(), ['prompt' => '-- -- --']) ?>
            <?= $form->field($model, 'label')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'slug')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'data_type')->dropDownList(Type::list(), ['prompt' => '-- -- --']) ?>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
