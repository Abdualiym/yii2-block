<?php
namespace frontend\widgets\news;

use abdualiym\languageClass\Language;
use abdualiym\block\entities\Text;
use yii\base\Widget;

class News extends Widget
{

    public function run()
    {
        $l = \Yii::$app->language;
        $l = Language::getLangByPrefix($l);
        $text = Text::find()
            ->where(['category_id' => 7])
            ->joinWith(['translations' => function($q) use ($l){
                $q->where(['lang_id' => $l['id']])->one();
            }])
            ->orderBy('created_at  desc')
            ->limit(3)
            ->asArray()
            ->all();
        return $this->render('news', [
            'news' => $text,
        ]);
    }
}