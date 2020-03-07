<?php

use abdualiym\block\entities\Blocks;
use abdualiym\block\helpers\Type;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\ActiveForm;
use abdualiym\block\entities\Categories;

/* @var $this View */
/* @var $blocks Blocks */
/* @var $model Categories */
/* @var $form ActiveForm */
?>

<div class="box">
    <div class="box-body">
        <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
        <?= $form->errorSummary($blocks) ?>
        <div class="row">
            <?php
            foreach ($blocks as $block) {
                foreach (Yii::$app->params['cms']['languages2'] as $key => $language) {
                    echo '<div class="col-sm-' . $block->size . '">' . ($block->getModelByType())->getFormField($form, $key, $language) . '</div>';
                    if (in_array($block->type, [Type::TEXT_COMMON, Type::STRING_COMMON, Type::IMAGE_COMMON, Type::FILE_COMMON])) {
                        break;
                    }
                }
            }
            ?>
        </div>
        <div class="form-group">
            <?= Html::submitButton(Yii::t('block', 'Save'), ['class' => 'btn btn-success']) ?>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>
