<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $text abdualiym\text\entities\Text */
/* @var $model abdualiym\text\forms\TextForm */

//$this->title = 'Обновить: ' . $text->translations[0]['title'];
//$this->params['breadcrumbs'][] = ['label' => Yii::t('block', $page ? 'Pages' : 'Articles'), 'url' => ['index', 'page' => $page]];
//$this->params['breadcrumbs'][] = ['label' => $text->translations[0]['title'], 'url' => ['view', 'id' => $text->id, 'page' => $page]];
$langList = \abdualiym\languageClass\Language::langList(Yii::$app->params['languages'], true);
?>

<div class="text-form">

    <?php $form = ActiveForm::begin(); ?>
    <?= $form->errorSummary($model) ?>
    <div class="box box-default">
        <div class="box-header with-border">Мета</div>
        <div class="box-body">
            <?= $form->field($model, 'lang_id')->dropDownList(\yii\helpers\ArrayHelper::map($langList, 'id', 'title'), ['prompt' => 'Для всех языков']) ?>

            <?= $form->field($model, 'key')->textInput() ?>

            <?= $form->field($model, 'value')->textarea() ?>

            <?= $form->field($model, 'text_id')->hiddenInput(['value' => $model->text_id])->label(false) ?>

            <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success btn-block']) ?>
        </div>
    </div>
    <?php ActiveForm::end(); ?>

</div>
