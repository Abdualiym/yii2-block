<?php

/* @var $this yii\web\View */
/* @var $model \abdualiym\block\entities\Block */

$this->title = 'Обновить';
$this->params['breadcrumbs'][] = ['label' => Yii::t('block', 'Blocks'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->label, 'url' => ['view', 'id' => $model->id]];
?>
<div class="block-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
