<?php

use abdualiym\block\entities\Categories;
use abdualiym\block\entities\Slides;

/* @var $this yii\web\View */
/* @var $model Slides */

$this->title = Yii::t('block', 'Update');
$this->params['breadcrumbs'][] = ['label' => $category->title_0, 'url' => ['index', 'slug' => $category->slug]];
$this->params['breadcrumbs'][] = ['label' => $model->title_0, 'url' => ['view', 'id' => $model->id, 'slug' => $category->slug]];
$this->params['breadcrumbs'][] = Yii::t('block', 'Update');
?>
<div class="articles-update">

    <?= $this->render('_form', [
        'model' => $model,
        'category' => $category
    ]) ?>

</div>
