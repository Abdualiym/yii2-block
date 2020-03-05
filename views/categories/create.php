<?php

use abdualiym\block\entities\Categories;

/* @var $this yii\web\View */
/* @var $model Categories */

$this->title = Yii::t('block', 'Create');
$this->params['breadcrumbs'][] = ['label' => Yii::t('block', 'Categories'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="article-categories-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
