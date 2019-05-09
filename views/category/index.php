<?php

use abdualiym\languageClass\Language;
use abdualiym\menu\components\MenuSlugHelper;
use abdualiym\block\entities\Category;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\helpers\Html;
use abdualiym\block\entities\Text;


/* @var $this yii\web\View */
/* @var $searchModel abdualiym\text\forms\CategorySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Категории';
$this->params['breadcrumbs'][] = $this->title;

$feed_with_image = (new \abdualiym\text\forms\CategoryForm())->getAttributeLabel('feed_with_image');


?>
<div class="user-index">

    <p>
        <?= Html::a(Html::tag('i', '', ['class' => 'fa fa-plus']) . ' Добавить', ['create'],
            ['class' => 'btn btn-success btn-flat']) ?>
    </p>

    <div class="box">
        <div class="box-body">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
//                'filterModel' => $searchModel,
                'columns' => [
                    [
                        'value' => function (Category $model) {
                            return Html::img($model->getThumbFileUrl('photo', 'admin'));
                        },
                        'format' => 'raw',
                        'contentOptions' => ['style' => 'width: 100px'],
                    ],
                    [
                        'attribute' => 'id',
                        'label' => 'Название',
                        'value' => function (Category $model) {
                            return Html::a(Html::encode($model->translations[0]['name']), [
                                'view',
                                'id' => $model->id
                            ]) . Html::tag('span','статей: '.Text::find()->where(['category_id' => $model->id,'status' => Text::STATUS_ACTIVE])->count(),['class' => 'label label-primary pull-right']);
                        },
                        'format' => 'raw',
                    ],
                    [
                        'attribute' => 'feed_with_image',
                        'value' => function ($model) {
                            $templates = \abdualiym\text\forms\CategoryForm::getTemplateTypes();

                            return $templates[$model->feed_with_image]['title'];
                        },
                        'label' => 'Тип шаблона',
                        'format' => 'raw',
                    ],
                    [
                        'attribute' => 'status',
                        'label' => 'Статус',
                        'value' => function (Category $model) {
                            return \abdualiym\text\helpers\TextHelper::statusLabel($model->status);
                        },
                        'format' => 'html',
                    ],
                    ['class' => ActionColumn::class],
                ],
            ]); ?>
        </div>
    </div>
</div>
