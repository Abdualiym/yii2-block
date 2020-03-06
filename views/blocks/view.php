<?php

use abdualiym\block\entities\Blocks;
use yii\helpers\Html;
use yii\widgets\DetailView;
use abdualiym\block\helpers\Type;

/* @var $this yii\web\View */
/* @var $model Blocks */
/* @var $category \abdualiym\block\entities\Categories */

$this->title = $model->label;
$this->params['breadcrumbs'][] = ['label' => $category->title, 'url' => ['index', 'slug' => $category->slug]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="articles-view">

    <p>
        <?= Html::a(Yii::t('block', 'Update'), ['update', 'id' => $model->id, 'slug' => $category->slug], ['class' => 'btn btn-primary']) ?>
    </p>

    <div class="row">
        <div class="col-sm-6">
            <div class="box">
                <div class="box-body">
                    <?= DetailView::widget([
                        'model' => $model,
                        'attributes' => [
                            'label',
                            'slug',
                            [
                                'attribute' => 'type',
                                'value' => function ($model) {
                                    return Type::name($model->type);
                                }
                            ],
                            'sort',
                        ],
                    ]) ?>
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="box">
                <div class="box-body">
                    <?= DetailView::widget([
                        'model' => $model,
                        'attributes' => [
                            'size',
                            'id',
                            'created_at:datetime',
                            'updated_at:datetime',
                        ],
                    ]) ?>
                </div>
            </div>
        </div>
    </div>

</div>


<p>
    <?= Html::a(Yii::t('block', 'Delete'), ['delete', 'id' => $model->id, 'slug' => $category->slug], [
        'class' => 'btn btn-danger',
        'data' => [
            'confirm' => Yii::t('block', 'Are you sure you want to delete this item?'),
            'method' => 'post',
        ],
    ]) ?>
</p>
