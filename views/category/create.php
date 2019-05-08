<?php

/* @var $this yii\web\View */
/* @var $model abdualiym\text\forms\CategoryForm */

$this->title = 'Добавить';
$this->params['breadcrumbs'][] = ['label' => 'Категории', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="category-create">

    <?= $this->render('_form', [
        'model' => $model
    ]) ?>

</div>
