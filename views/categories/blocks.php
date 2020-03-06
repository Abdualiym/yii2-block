<?php

use abdualiym\block\entities\Categories;
use abdualiym\block\entities\Blocks;

/* @var $this yii\web\View */
/* @var $model Categories */
/* @var $blocks Blocks */

$this->title = $model->title;
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="article-categories-create">

    <?= $this->render('_blocks_form', [
        'model' => $model,
        'blocks' => $blocks,
    ]) ?>

</div>
