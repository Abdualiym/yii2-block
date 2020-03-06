<?php

use abdualiym\block\entities\Categories;
use abdualiym\block\forms\CategoriesSearch;
use yii\grid\GridView;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $searchModel CategoriesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('block', 'Categories');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="article-categories-index">

    <p>
        <?= Html::a(Yii::t('block', 'Create'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

                        [
                            'attribute' => 'title',
                            'format' => 'raw',
                            'value' => function ($model) {
                                return Html::a($model->title, ['view', 'id' => $model->id]);
                            }
                        ],
            'slug',
            [
                'attribute' => 'id',
                'value' => function (Categories $model) {
                    return Html::a(Yii::t('block','Blocks'), ['blocks/index', 'slug' => $model->slug]);
                },
                'label' => Yii::t('block', 'View'),
                'format' => 'raw'
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
