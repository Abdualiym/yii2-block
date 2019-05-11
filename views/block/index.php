<?php

use abdualiym\block\entities\Block;
use abdualiym\block\forms\BlockForm;
use yii\grid\GridView;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $searchModel abdualiym\text\forms\BlockSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */


$this->title = Yii::t('block', 'Blocks');
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="user-index">

    <p>
        <?= Html::a(Html::tag('i', '', ['class' => 'fa fa-plus']) . ' Добавить', ['add'], ['class' => 'btn btn-success btn-flat']) ?>
    </p>

    <div class="box">
        <div class="box-body">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    [
                        'value' => function (Block $model) {
                            return Html::img($model->getThumbFileUrl('file', 'admin'));
                        },
                        'format' => 'raw',
                    ],
                    [
                        'attribute' => 'parent_id',
                        'label' => Yii::t('block', 'Parent'),
                        'value' => function (Block $model) {
                            return $model->getParent() ? $model->getParent()->label : null;
                        },
                        'filter' => Block::parentList()
                    ],
//                [
//                    'attribute' => 'date',
//                    'label' => Yii::t('block', 'Date'),
//                    'format' => 'date',
//                ],
                    [
                        'attribute' => 'label',
                        'label' => 'Название',
                        'value' => function (Block $model) {
                            return Html::a(Html::encode($model->label, ['view', 'id' => $model->id]));
                        },
                        'format' => 'raw',
                    ],
                ]
            ]) ?>
        </div>
    </div>
</div>
