<?php

use abdualiym\languageClass\Language;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use abdualiym\block\helpers\Type;

/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */
/* @var $model abdualiym\block\forms\BlockForm */
/* @var $block \abdualiym\block\entities\Block */


$thumb = isset($block->photo) ? $block->getThumbFileUrl('data_helper', 'thumb') : '';
?>

<div class="block-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="box box-default">
        <div class="box-body">
            <?= $form->errorSummary($model) ?>
            <?= $form->field($model, 'parent_id')->dropDownList($model::parentList(), ['prompt' => '-- -- --']) ?>
            <?= $form->field($model, 'label')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'slug')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'common')->checkbox() ?>
            <?= $form->field($model, 'data_type')->dropDownList(Type::list(), ['prompt' => '-- -- --']) ?>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
