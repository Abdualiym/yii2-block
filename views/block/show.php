<?php

use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\DetailView;
use abdualiym\block\entities\Block;

/* @var $this yii\web\View */
/* @var $model Block */

$this->title = $model->label;
$this->params['breadcrumbs'][] = ['label' => Yii::t('block', 'Blocks'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-view">

    <p>
        <?= Html::a('Обновить', ['edit', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
    </p>

    <div class="row">
        <div class="col-sm-6">
            <div class="box">
                <div class="box-header with-border"><?= Yii::t('block', 'Meta data') ?></div>
                <div class="box-body">
                    <?= DetailView::widget([
                        'model' => $model,
                        'attributes' => [
                            'id',
                            [
                                'attribute' => 'parent_id',
                                'value' => function (Block $model) {
                                    return $model->parent ? $model->parent->label : null;
                                },
                            ],
                            [
                                'attribute' => 'parent_id',
                                'value' => function (Block $model) {
                                    return $model->parent ? $model->parent->label : null;
                                },
                            ],
                        ],
                    ]) ?>
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="box">
                <div class="box-header with-border"><?= Yii::t('block', 'Content') ?></div>
                <div class="box-body">
                    <?= DetailView::widget(['model' => $model,
                        'attributes' => [
                            [
                                'attribute' => 'created_at',
                                'format' => 'datetime',
                                'label' => Yii::t('block', 'Created at')
                            ],
                            [
                                'attribute' => 'updated_at',
                                'format' => 'datetime',
                                'label' => Yii::t('block', 'Updated at')
                            ],
                        ],
                    ]) ?>

                </div>
            </div>
        </div>
    </div>


</div>
