<?php

use abdualiym\block\entities\Block;
use abdualiym\block\helpers\Type;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model Block */
/* @var $module \abdualiym\block\Module */

$this->title = $model->label;
$this->params['breadcrumbs'][] = ['label' => Yii::t('block', 'Blocks'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$module = Yii::$app->controller->module;
?>
<div class="user-view">

    <p>
        <?= Html::a('Изменить', ['edit', 'id' => $model->id], ['class' => 'btn btn-success']) ?>
        <?= Html::a('Обновить', ['update', 'id' => $model->id, 'show' => true], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Удалить', ['drop', 'id' => $model->id], [
            'class' => 'btn btn-danger pull-right',
            'data' => [
                'confirm' => 'Вы уверены?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <div class="row">
        <div class="col-sm-6">
            <div class="box">
                <div class="box-header with-border"><?= Yii::t('block', 'Meta data') ?></div>
                <div class="box-body">
                    <?= DetailView::widget([
                        'model' => $model,
                        'attributes' => [
                            [
                                'attribute' => 'parent_id',
                                'value' => function (Block $model) {
                                    return $model->parent ? $model->parent->label : null;
                                },
                            ],
                            'label',
                            'slug',
                            [
                                'attribute' => 'data_type',
                                'value' => function (Block $model) {
                                    return Type::name($model->data_type);
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
                            'id',
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


    <div class="box box-primary">
        <div class="box-header with-border">Контент</div>
        <div class="box-body">

            <?php if ($model->isCommon()): ?>
                <?= $model->showData(); ?>
            <?php else: ?>
                <ul class="nav nav-tabs" role="tablist">
                    <?php foreach ($module->languages as $key => $language) : ?>
                        <li role="presentation" <?= $key == 0 ? 'class="active"' : '' ?>>
                            <a href="#<?= $key ?>" aria-controls="<?= $key ?>" role="tab" data-toggle="tab"><?= $language ?></a>
                        </li>
                    <?php endforeach; ?>
                </ul>
                <div class="tab-content">
                    <br>
                    <?php foreach ($module->languages as $key => $language) : ?>
                        <div role="tabpanel" class="tab-pane <?= $key == 0 ? 'active' : '' ?>" id="<?= $key ?>">
                            <?= $model->showData($key); ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

        </div>
    </div>


</div>
