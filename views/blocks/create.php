<?php

use abdualiym\block\entities\Categories;
use abdualiym\block\entities\Blocks;

/* @var $this yii\web\View */
/* @var $model Blocks */
/* @var $category Categories */

$this->title = Yii::t('block', 'Create');
$this->params['breadcrumbs'][] = ['label' => $category->title, 'url' => ['index', 'slug' => $category->slug]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="articles-create">

    <?= $this->render('_form', [
        'model' => $model,
        'category' => $category
    ]) ?>

</div>
