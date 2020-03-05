<?php

use abdualiym\block\entities\Categories;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model Categories */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('block', 'Categories'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="article-categories-view">

    <p>
        <?= Html::a(Yii::t('block', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
    </p>

    <div class="box">
        <div class="box-body row">
            <div class="col-sm-6">
                <?= DetailView::widget([
                    'model' => $model,
                    'attributes' => [
                        'title',
                        'slug',
                    ],
                ]) ?>
            </div>
            <div class="col-sm-6">
                <?= DetailView::widget([
                    'model' => $model,
                    'attributes' => [
                        'created_at:datetime',
                        'updated_at:datetime',
                    ],
                ]) ?>
            </div>
        </div>
    </div>

    <?= Html::a(Yii::t('block', 'Delete'), ['delete', 'id' => $model->id], [
        'class' => 'btn btn-danger',
        'data' => [
            'confirm' => Yii::t('block', 'Are you sure you want to delete this item?'),
            'method' => 'post',
        ],
    ]) ?>

</div>
