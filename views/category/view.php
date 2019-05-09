<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $category abdualiym\text\entities\Category */

$this->title = $category->translations[0]['name'];
$this->params['breadcrumbs'][] = ['label' => 'Категории', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$langList = \abdualiym\languageClass\Language::langList(Yii::$app->params['languages'], true);
?>
<div class="user-view">

    <p>
        <?= Html::a('Обновить', ['update', 'id' => $category->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $category->id], [
            'class' => 'btn btn-danger pull-right',
            'data' => [
                'confirm' => 'Вы уверены?',
                'method' => 'post',
            ],
        ]) ?>
        <?php if ($category->isActive()): ?>
            <?= Html::a(Yii::t('app', 'Draft'), ['draft', 'id' => $category->id], ['class' => 'btn btn-default pull-right', 'data-method' => 'post']) ?>
        <?php else: ?>
            <?= Html::a(Yii::t('app', 'Activate'), ['activate', 'id' => $category->id], ['class' => 'btn btn-success', 'data-method' => 'post']) ?>
        <?php endif; ?>
    </p>

    <?= DetailView::widget([
        'model' => $category,
        'attributes' => [
            [
                'attribute' => 'photo',
                'value' => function ($model) {
                    return Html::img($model->getThumbFileUrl('photo', 'admin'));
                },
                'label' => 'Фото',
                'format' => 'raw',
            ],
            'id',
            [
                'attribute' => 'status',
                'value' => \abdualiym\text\helpers\CategoryHelper::statusLabel($category->status),
                'format' => 'raw',
            ],
            [
                'attribute' => 'id',
                'value' => function ($model) {
                    return $model->translations[0]['name'];
                },
                'label' => 'Название'
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
        ],
    ]) ?>

    <div class="box box-default">

        <div class="box-header with-border">Контент</div>

        <div class="box-body">
            <!-- Nav tabs -->
            <ul class="nav nav-tabs" role="tablist">
                <?php
                $j = 0;
                foreach ($category->translations as $i => $translation) {
                    if (isset($langList[$translation->lang_id])) {
                        $j++;
                        ?>
                        <li role="presentation" <?= $j === 1 ? 'class="active"' : '' ?>>
                            <a href="#<?= $langList[$translation->lang_id]['prefix'] ?>"
                               aria-controls="<?= $langList[$translation->lang_id]['prefix'] ?>"
                               role="tab" data-toggle="tab">
                                <?= '(' . $langList[$translation->lang_id]['prefix'] . ') ' . $langList[$translation->lang_id]['title'] ?>
                            </a>
                        </li>
                    <?php }
                }
                ?>
            </ul>

            <!-- Tab panes -->
            <div class="tab-content">
                <br>
                <?php
                $j = 0;
                foreach ($category->translations as $i => $translation) {
                    if (isset($langList[$translation->lang_id])) {
                        $j++;
                        ?>
                        <div role="tabpanel" class="tab-pane <?= $j === 1 ? 'active' : '' ?>"
                             id="<?= $langList[$translation->lang_id]['prefix'] ?>">
                            <?= DetailView::widget(['model' => $translation,
                                'attributes' => [
                                    [
                                        'attribute' => 'name',
                                        'label' => Yii::t('block', 'Title')
                                    ],
                                    [
                                        'attribute' => 'slug',
                                        'label' => Yii::t('block', 'Slug')
                                    ],
                                ],
                            ]) ?>
                            <?= $translation->description ?>
                        </div>
                    <?php }
                } ?>
            </div>
        </div>
    </div>

    <?= DetailView::widget(['model' => $category,
        'attributes' => [
            [
                'attribute' => 'createdBy.username',
                'label' => Yii::t('block', 'Created by')
            ],
            [
                'attribute' => 'created_at',
                'format' => 'datetime',
                'label' => Yii::t('block', 'Created at')
            ],
            [
                'attribute' => 'updatedBy.username',
                'label' => Yii::t('block', 'Updated by')
            ],
            [
                'attribute' => 'updated_at',
                'format' => 'datetime',
                'label' => Yii::t('block', 'Updated at')
            ],
        ],
    ]) ?>

</div>
