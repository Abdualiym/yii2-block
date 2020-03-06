<?php

use abdualiym\block\forms\BlocksSearch;
use abdualiym\block\entities\Blocks;
use yii\grid\GridView;
use yii\helpers\Html;
use abdualiym\block\helpers\Type;

/* @var $this yii\web\View */
/* @var $searchModel BlocksSearch */
/* @var $category \abdualiym\block\entities\Categories */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = $category->title;
$this->params['breadcrumbs'][] = ['label' => $category->title, 'url' => ['/block/categories/view', 'id' => $category->id]];
?>
<div class="articles-index">

    <p>
        <?= Html::a(Yii::t('block', 'Create'), ['create', 'slug' => $category->slug], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            'sort',
            [
                'attribute' => 'label',
                'value' => function (Blocks $model) use ($category) {
                    return Html::a($model->label, ['update', 'id' => $model->id, 'slug' => $category->slug]);
                },
                'format' => 'raw'
            ],
            'slug',
            [
                'attribute' => 'type',
                'value' => function ($model) {
                    return Type::name($model->type);
                }
            ],
            'size',
            'created_at:datetime',
            'updated_at:datetime',
        ],
    ]); ?>
</div>
