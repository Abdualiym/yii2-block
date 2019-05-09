<?php

/* @var $this yii\web\View */
/* @var $model abdualiym\text\forms\TextForm */

$this->title = 'Добавить';
$this->params['breadcrumbs'][] = ['label' => Yii::t('block', $page ? 'Pages' : 'Articles'), 'url' => ['index', 'page' => $page]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="category-create">

    <?= $this->render('_form', [
        'model' => $model,
        'page' => $page,
    ]) ?>

</div>
