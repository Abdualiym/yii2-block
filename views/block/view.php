<?php

use abdualiym\block\entities\Block;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model \abdualiym\block\entities\Block */

$this->title = $model->label;
$this->params['breadcrumbs'][] = $this->title;
$module = Yii::$app->controller->module;
?>
<div class="user-view">

    <p>
        <?= Html::a('Обновить', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
    </p>

    <div class="row">
        <div class="col-sm-6">
            <div class="box">
                <div class="box-header with-border"><?= Yii::t('block', 'Date') ?></div>
                <div class="box-body">
                    <?= DetailView::widget([
                        'model' => $model,
                        'attributes' => [
                            [
                                'attribute' => 'parent_id',
                                'value' => function (Block $model) {
                                    return isset($model->parent_id) ? $model->parent_id->label : null;
                                },
                                'label' => Yii::t('block', 'Parent')
                            ],
                        ],
                    ]) ?>
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="box">
                <div class="box-header with-border"><?= Yii::t('block', 'Date') ?></div>
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
