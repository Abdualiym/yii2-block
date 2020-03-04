<?php

use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $text abdualiym\text\entities\Text */

$this->title = $text->translations[1]['title'];
$this->params['breadcrumbs'][] = ['label' => Yii::t('block', $page ? 'Pages' : 'Articles'), 'url' => ['index', 'page' => $page]];
$this->params['breadcrumbs'][] = $this->title;

$langList = \abdualiym\languageClass\Language::langList(Yii::$app->params['languages'], true);

?>
<div class="user-view">

    <p>
        <?= Html::a('Удалить', ['delete', 'id' => $text->id], [
            'class' => 'btn btn-danger pull-right',
            'data' => [
                'confirm' => 'Вы уверены?',
                'method' => 'post',
            ],
        ]) ?>
        <?= Html::a('Обновить', ['update', 'id' => $text->id, 'page' => $page], ['class' => 'btn btn-primary']) ?>
        <?php if ($text->isActive()): ?>
            <?= Html::a(Yii::t('app', 'Draft'), ['draft', 'id' => $text->id], ['class' => 'btn btn-default pull-right', 'data-method' => 'post']) ?>
        <?php else: ?>
            <?= Html::a(Yii::t('app', 'Activate'), ['activate', 'id' => $text->id], ['class' => 'btn btn-success', 'data-method' => 'post']) ?>
        <?php endif; ?>
    </p>

    <div class="row <?= $page ? 'hidden' : '' ?>">
        <div class="col-sm-6">
            <?= DetailView::widget([
                'model' => $text,
                'attributes' => [
                    'id',
                    ['attribute' => 'id',
                        'value' => function ($model) {
                            return
                                isset($model->category->translations[0]) ?
                                    $model->category->translations[0]->name
                                    : '';
                        },
                        'label' => Yii::t('block', 'Category')
                    ],
                    [
                        'attribute' => 'status',
                        'value' => \abdualiym\text\helpers\TextHelper::statusLabel($text->status),
                        'format' => 'raw',
                    ],
                    [
                        'attribute' => 'date',
                        'format' => 'date',
                        'label' => Yii::t('block', 'Date')
                    ],
                    [
                        'attribute' => 'is_article',
                        'format' => 'raw',
                        'value' => function ($model) {
                            return $model->is_article ? Yii::t('block', 'Article') : Yii::t('block', 'Page');
                        },
                        'label' => Yii::t('block', 'Type')
                    ],
                ],
            ]) ?>
        </div>
        <div class="col-sm-6">
            <div class="box">
                <div class="box-header with-border"><?= Yii::t('block', 'Photo') ?></div>
                <div class="box-body">
                    PHOTO...
                </div>
            </div>
        </div>
    </div>

    <div class="box box-default">

        <div class="box-header with-border">Контент</div>

        <div class="box-body">
            <!-- Nav tabs -->
            <ul class="nav nav-tabs" role="tablist">
                <?php
                $j = 0;
                foreach ($text->translations as $i => $translation) {
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
                foreach ($text->translations as $i => $translation) {
                    if (isset($langList[$translation->lang_id])) {
                        $j++;
                        ?>
                        <div role="tabpanel" class="tab-pane <?= $j === 1 ? 'active' : '' ?>"
                             id="<?= $langList[$translation->lang_id]['prefix'] ?>">
                            <?= DetailView::widget(['model' => $translation,
                                'attributes' => [
                                    [
                                        'attribute' => 'title',
                                        'label' => Yii::t('block', 'Title')
                                    ],
                                    [
                                        'attribute' => 'slug',
                                        'label' => Yii::t('block', 'Slug')
                                    ],
                                    [
                                        'attribute' => 'description',
                                        'label' => Yii::t('block', 'Description')
                                    ],
                                ],
                            ]) ?>

                            <?= $translation->content ?>

                        </div>
                    <?php }
                } ?>
            </div>
        </div>
    </div>

    <?= DetailView::widget(['model' => $text,
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


    <div class="box" id="photos">
        <div class="box-header with-border">Photos</div>
        <div class="box-body">

            <div class="row">
                <?php foreach ($text->photos as $photo): ?>
                    <div class="col-md-2 col-xs-3" style="text-align: center">
                        <div class="btn-group">
                            <?= Html::a('<span class="glyphicon glyphicon-arrow-left"></span>', ['move-photo-up', 'id' => $text->id, 'photo_id' => $photo->id], [
                                'class' => 'btn btn-default',
                                'data-method' => 'post',
                            ]); ?>
                            <?= Html::a('<span class="glyphicon glyphicon-remove"></span>', ['delete-photo', 'id' => $text->id, 'photo_id' => $photo->id], [
                                'class' => 'btn btn-default',
                                'data-method' => 'post',
                                'data-confirm' => 'Remove photo?',
                            ]); ?>
                            <?= Html::a('<span class="glyphicon glyphicon-arrow-right"></span>', ['move-photo-down', 'id' => $text->id, 'photo_id' => $photo->id], [
                                'class' => 'btn btn-default',
                                'data-method' => 'post',
                            ]); ?>
                        </div>
                        <div>
                            <?= Html::a(
                                Html::img($photo->getThumbFileUrl('file', 'thumb')),
                                $photo->getUploadedFileUrl('file'),
                                ['class' => 'thumbnail', 'target' => '_blank']
                            ) ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <?php $form = ActiveForm::begin([
                'options' => ['enctype' => 'multipart/form-data'],
            ]); ?>

            <?= $form->field($photosForm, 'files[]')->label(false)->widget(\kartik\file\FileInput::class, [
                'options' => [
                    'accept' => 'image/*',
                    'multiple' => true,
                ]
            ]) ?>

            <div class="form-group">
                <?= Html::submitButton('Upload', ['class' => 'btn btn-success']) ?>
            </div>

            <?php ActiveForm::end(); ?>

        </div>
    </div>


    <div class="box">
        <div class="box-body">
            <?= GridView::widget([
                'dataProvider' => $metaFieldProvider,
                'filterModel' => $searchMetaFieldModel,
                'columns' => [
                    ['class' => \yii\grid\SerialColumn::class],
                    [
                        'attribute' => 'lang_id',
                        'value' => function ($model) {
                            $langList = \abdualiym\languageClass\Language::langList(Yii::$app->params['languages'], true);
                            return $model->lang_id ? $langList[$model->lang_id]['title'] : 'Для всех языков';
                        },
                        'label' => 'Язык'
                    ],
                    'key',
                    'value',
                    [
                        'class' => 'yii\grid\ActionColumn',
                        'template' => '{update}&nbsp;&nbsp;&nbsp;{delete}',
                        'buttons' => [
                            'update' => function ($url, $model, $key) {
                                return Html::a('<span class="fa fa-edit"></span>', [
                                    'text/meta-update', 'id' => $model->id
                                ]);
                            },
                            'delete' => function ($url, $model, $key) {
                                global $page;
                                return Html::a('<span class="fa fa-times-circle"></span>',
                                    [
                                        'text/meta-delete',
                                        'id' => $model->id,
                                        'text_id' => $model->text_id,
                                        'page' => $page
                                    ],
                                    [
                                        'options' => ['target' => '_blank'],
                                        'data' => [
                                            'confirm' => 'Вы уверены?',
                                            'method' => 'post',
                                        ]
                                    ]);
                            },
                        ],
                    ],
                ]
            ]) ?>
        </div>
    </div>


    <?php $form = ActiveForm::begin(['action' => ['meta-create', 'id' => $text->id]]); ?>
    <?= $form->errorSummary($meta) ?>
    <div class="box box-default">
        <div class="box-header with-border">Добавить новую</div>
        <div class="box-body">
            <div class="row">
                <div class="col-sm-2">
                    <?= $form->field($meta, 'lang_id')->dropDownList(ArrayHelper::map($langList, 'id', 'title'), ['prompt' => 'Для всех языков']) ?>
                </div>
                <div class="col-sm-3">
                    <?= $form->field($meta, 'key')->textInput() ?>
                </div>
                <div class="col-sm-5">
                    <?= $form->field($meta, 'value')->textInput() ?>
                </div>
                <div class="col-sm-2">
                    <?= $form->field($meta, 'text_id')->hiddenInput(['value' => $text->id])->label(false) ?>
                    <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success btn-block']) ?>
                </div>
            </div>
        </div>
    </div>
    <?php ActiveForm::end(); ?>

</div>
