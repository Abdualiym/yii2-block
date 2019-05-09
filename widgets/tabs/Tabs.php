<?php

namespace frontend\widgets\tabs;


use abdualiym\languageClass\Language;
use abdualiym\block\entities\Category;
use abdualiym\block\entities\Text;
use abdualiym\menu\entities\Menu;
use Yii;
use yii\base\Widget;
use yii\helpers\ArrayHelper;
use yii\helpers\StringHelper;

class Tabs extends Widget
{
    public $ids; // array []

    public function run()
    {
        $l = Language::getLangByPrefix(Yii::$app->language);
        Yii::$app->formatter->locale = Yii::$app->language;

        $categories = Category::find()
            ->where(['id' => $this->ids])
            ->with(['translations' => function ($q) use ($l) {
                $q->where(['lang_id' => $l['id']]);
            }])
            ->asArray()
            ->all();

        $texts = Text::find()
            ->where(['category_id' => $this->ids])
            ->with(['translations' => function ($q) use ($l) {
                $q->where(['lang_id' => $l['id']]);
            }])
            ->limit(6)
            ->orderBy('date DESC')
            ->asArray()
            ->all();
        foreach ($categories as $key => $category) {
            $categories[$key]['translations'][0]['slug'] = Menu::getSlug($category['translations'][0]['slug'], 'category', $category['id'], $l);
            $categories[$key]['translations'][0]['description'] = StringHelper::truncateWords(strip_tags($category['translations'][0]['description']), 10);
            $categories[$key]['created_at'] = Yii::$app->formatter->asDate($category['created_at']);
        }
        $categories = ArrayHelper::index($categories, function ($element) {
            return $element['id'];
        });
        $arr = [];
        foreach ($texts as $key => $text) {
            $texts[$key]['translations'][0]['slug'] = Menu::getSlug($text['translations'][0]['slug'], 'content', $text['id'], $l);
            $texts[$key]['translations'][0]['description'] = StringHelper::truncateWords(strip_tags($text['translations'][0]['description']), 10);
            $texts[$key]['date'] = Yii::$app->formatter->asDate($text['date']);
            $texts[$key]['created_at'] = Yii::$app->formatter->asDate($text['created_at']);
            unset ($texts[$key]['translations'][0]['content']);

            foreach ($this->ids as $id) {
                if ($text['category_id'] == $id) {
                    $arr[$id][] = $texts[$key];
                }
            }
        }

//        VarDumper::dump($categories,5,true);die;
        return $this->render('tabs', [
            'categories' => $categories,
            'texts' => $arr
        ]);
    }
}