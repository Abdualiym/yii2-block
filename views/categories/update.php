<?php
use abdualiym\block\entities\Categories;

/* @var $this yii\web\View */
/* @var $model Categories */

$this->title = Yii::t('block', 'Update');
$this->params['breadcrumbs'][] = ['label' => Yii::t('block', 'Categories'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('block', 'Update');
?>
<div class="article-categories-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
