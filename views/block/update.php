<?php

/* @var $this yii\web\View */
/* @var $text abdualiym\text\entities\Text */
/* @var $model abdualiym\text\forms\TextForm */

$this->title = 'Обновить: ' . $text->translations[0]['title'];
$this->params['breadcrumbs'][] = ['label' => Yii::t('block', $page ? 'Pages' : 'Articles'), 'url' => ['index', 'page' => $page]];
$this->params['breadcrumbs'][] = ['label' => $text->translations[0]['title'], 'url' => ['view', 'id' => $text->id, 'page' => $page]];
?>
<div class="text-update">

    <?= $this->render('_form', [
        'model' => $model,
        'text' => $text,
        'page' => $page,
    ]) ?>

</div>
