<?php

/* @var $this yii\web\View */
/* @var $category abdualiym\text\entities\Category */
/* @var $model abdualiym\text\forms\CategoryForm */

$this->title = 'Обновить: ' . $category->translations[0]['name'];
$this->params['breadcrumbs'][] = ['label' => 'Категории', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $category->translations[0]['name'], 'url' => ['view', 'id' => $category->id]];
$this->params['breadcrumbs'][] = 'Обновить';
?>
<div class="category-update">

    <?= $this->render('_form', [
        'model' => $model,
        'category' => $category,
    ]) ?>

</div>
