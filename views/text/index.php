<?php

use abdualiym\menu\components\MenuSlugHelper;
use abdualiym\languageClass\Language;
use abdualiym\block\entities\Text;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use abdualiym\block\entities\CategoryTranslation;
use abdualiym\block\forms\TextForm;

/* @var $this yii\web\View */
/* @var $searchModel abdualiym\text\forms\BlockSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */


$this->title = Yii::t('block', $page ? 'Pages' : 'Articles');
$this->params['breadcrumbs'][] = $this->title;
$columns = [];
if (!$page) {
    $columns[] = [
        'value' => function (Text $model) {
            return $model->mainPhoto ? Html::img($model->mainPhoto->getThumbFileUrl('file', 'admin')) : null;
        },
        'format' => 'raw',
        'contentOptions' => ['style' => 'width: 100px'],
    ];
    $columns[] =
        [
            'attribute' => 'category_id',
            'label' => Yii::t('block', 'Category'),
            'value' => function (Text $model) {
                return $model->category ? $model->category->translations[0]['name'] : 'No';
            },
            'filter' => (new TextForm())->categoriesList(true)
        ];
    $columns[] =
        [
            'attribute' => 'date',
            'label' => Yii::t('block', 'Date'),
            'format' => 'date',
        ];

}
$columns[] = [
    'attribute' => 'title',
    'label' => 'Название',
    'value' => function (Text $model) {
        foreach ($model->translations as $translation) {
            if ($translation['lang_id'] == (Language::getLangByPrefix('ru'))['id']) {
                $translate = $translation;
            }
        }
        return Html::a(Html::encode($translate['title']), ['view', 'id' => $model->id, 'page' => (Yii::$app->request->get('page') ? true : false)]);
    },
    'format' => 'raw',
];
$columns[] =
    [
        'attribute' => 'status',
        'label' => Yii::t('block', 'Status'),
        'value' => function (Text $model) {
            return \abdualiym\text\helpers\TextHelper::statusLabel($model->status);
        },
        'format' => 'html',
        'filter' => [Text::STATUS_ACTIVE => 'Актывные', Text::STATUS_DRAFT => 'Черновики']
    ];
?>
<div class="user-index">

    <p>
        <?= Html::a(Html::tag('i','',['class' => 'fa fa-plus']).' Добавить', ['create', 'page' => $page], ['class' => 'btn btn-success btn-flat']) ?>
    </p>

    <div class="box">
        <div class="box-body">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => $columns]) ?>
        </div>
    </div>
</div>
