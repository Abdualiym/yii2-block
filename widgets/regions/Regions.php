<?php

namespace frontend\widgets\regions;

use abdualiym\languageClass\Language;
use abdualiym\block\entities\Text;
use Yii;
use yii\base\Widget;

class Regions extends Widget
{
    public $categoryId;

    public function run()
    {
        $language = Language::getLangByPrefix(Yii::$app->language);

        $texts = Text::find()
            ->where(['category_id' => $this->categoryId])
            ->with(['metaFields', 'translations' => function ($q) use ($language) {
                $q->where(['lang_id' => $language['id']]);
            }])
            ->all();

        return $this->render('regions', [
            'texts' => $texts,
            'language' => $language
        ]);
    }
}