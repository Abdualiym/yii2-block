<?php

use abdualiym\languageClass\Language;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */
/* @var $model abdualiym\text\forms\CategoryForm */
/* @var $category abdualiym\text\entities\Category */

$langList = Language::langList(Yii::$app->params['languages'], true);

foreach ($model->translations as $i => $translation) {
    if (!$translation->lang_id) {
        $q = 0;
        foreach ($langList as $k => $l) {
            if ($i == $q) {
                $translation->lang_id = $k;
            }
            $q++;
        }
    }
}

?>

    <div class="category-form">

        <?php $form = ActiveForm::begin([
            'options' => ['enctype' => 'multipart/form-data']
        ]); ?>
        <div class="box" id="photos">
            <div class="box-header with-border">Фотографий</div>
            <div class="box-body">
                <?= $form->field($model, 'photo')->widget(\kartik\file\FileInput::class, [
                    'pluginOptions' => [
                        'initialPreview'=>[
                            isset($category) ? Html::img($category->getImageFileUrl('photo', 'admin'),['class' => 'img-responsive']): '',
                        ],
                        'overwriteInitial'=>true
                    ],
                    'options' => [
                        'accept' => 'image/*'
                    ]
                ])->label('Загрузить фотографий') ?>
            </div>
        </div>
        <div class="box box-default">

            <div class="box-header with-border">Категория</div>
            <div class="box-body">
                <?= $form->errorSummary($model) ?>
                <?php // $form->field($model, 'feed_with_image')->dropDownList($model::getCategoryTypes()) ?>
                <?= $form->field($model, 'feed_with_image')
                    ->radioList(ArrayHelper::getColumn($model->getTemplateTypes(), 'img'), [
                        'encode' => false,
                        'item' => function ($index, $label, $name, $checked, $value) {
                            if($checked){
                                $checked = 'checked';
                            }
                            $return = '<label>';
                            $return .= '<input '.$checked.' type="radio" class="hidden" name="' . $name . '" value="' . $value . '" tabindex="3">';
                            $return .= $label;
                            $return .= '</label>';

                            return $return;
                        }
                    ]) ?>

            </div>


            <div class="box-body">

                <!-- Nav tabs -->
                <ul class="nav nav-tabs" role="tablist">
                    <?php foreach ($model->translations as $i => $translation): ?>
                        <li role="presentation" <?= $i == 0 ? 'class="active"' : '' ?>>
                            <a href="#<?= $langList[$translation->lang_id]['prefix'] ?>"
                               aria-controls="<?= $langList[$translation->lang_id]['prefix'] ?>" role="tab"
                               data-toggle="tab">
                                <?= '(' . $langList[$translation->lang_id]['prefix'] . ') ' . $langList[$translation->lang_id]['title'] ?>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>

                <!-- Tab panes -->
                <div class="tab-content">
                    <br>
                    <?php foreach ($model->translations as $i => $translation): ?>
                        <div role="tabpanel" class="tab-pane <?= $i == 0 ? 'active' : '' ?>"
                             id="<?= $langList[$translation->lang_id]['prefix'] ?>">
                            <?= $form->field($translation, '[' . $i . ']name')->textInput(['maxlength' => true])->label("Название на (" . $langList[$translation->lang_id]['title'] . ")") ?>
                            <?php //= $form->field($model->translations, 'slug[' . $i . ']')->textInput(['maxlength' => true]) ?>
                            <?php //= $form->field($model->translations, 'title[' . $i . ']')->textInput(['maxlength' => true]) ?>
                            <?= $form->field($translation, '[' . $i . ']description')->widget(\mihaildev\ckeditor\CKEditor::className()); ?>
                            <?= $form->field($translation, '[' . $i . ']lang_id')->hiddenInput(['value' => $langList[$translation->lang_id]['id']])->label(false) ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>


        <div class="form-group">
            <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>

<?php

$script = <<<JS
$(function () {
    $('input[checked]').siblings('.btn-radio').addClass('active').siblings('.img-radio').css('opacity','1');
    $('.btn-radio').click(function(e) {
        $('.btn-radio').not(this).removeClass('active')
            .siblings('input').prop('checked',false)
            .siblings('.img-radio').css('opacity','0.5');
        $(this).addClass('active')
            .siblings('input').prop('checked',true)
            .siblings('.img-radio').css('opacity','1');
    });
});
JS;

$css = <<<CSS
    #manager-table td{
        border: 1px solid #ccc;
        padding: 10px;
    }
    
    .btn-radio {
        width: 100%;
    }
    .img-radio {
        opacity: 0.5;
        margin-bottom: 5px;
    }
    
    .space-20 {
        margin-top: 20px;
    }
CSS;


$this->registerCss($css);
$this->registerJs($script);

