<?php

namespace abdualiym\block\entities;

use abdualiym\languageClass\Language;
use abdualiym\menu\entities\Menu;
use abdualiym\menu\components\MenuSlugHelper;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\helpers\VarDumper;

/**
 * @property integer $id
 * @property integer $lang_id
 * @property string $title
 * @property string $slug
 * @property string $description
 * @property string content
 */
class TextTranslation extends ActiveRecord
{
    public static function create($lang_id, $title, $description, $content, $meta): self
    {
        $translation = new static();
        $translation->lang_id = $lang_id;
        $translation->title = $title;
        $translation->content = $content;
        $translation->description = $description;
        $translation->meta_json = Json::encode(1);
        return $translation;
    }

    public static function blank($lang_id): self
    {
        $translation = new static();
        $translation->lang_id = $lang_id;
        return $translation;
    }

    public function edit($title, $description, $content, $meta)
    {
        $this->title = $title;
        $this->description = $description;
        $this->content = $content;
        $this->meta_json = Json::encode(1);
    }

    public static function renderTranslation(array $translation)
    {
        $langList = Language::langList();
        if (empty($translation['content'])) {

            $translations = self::find()->where(['parent_id' => $translation['parent_id']])->asArray()->all();
            $alterTranslation = [];
            foreach ($translations as $k => $tr) {
                if (!empty($tr['content'])) {
                    foreach ($langList as $l) {
                        if ($l['id'] == $tr['lang_id']) {
                            $alterTranslation[$k]['lang'] = $l;
                        }
                    }
                    $alterTranslation[$k]['link'] = \Yii::$app->params['frontendHostInfo'] . '/'
                        . $alterTranslation[$k]['lang']['prefix']
                        . $tr['slug'];

                }
            }
            if (!empty($alterTranslation)) {
                $alert = Html::tag('div',
                    \Yii::t('app', 'This content is empty in the current language!'),
                    ['class' => 'alert alert-info']);
                $links = '';

                foreach ($alterTranslation as $k => $alter) {
                    $links .= Html::a(Language::contentExist($alter['lang']['id']), $alter['link'], ['class' => 'btn-link']);
                    $links .= count($alterTranslation) > $k?', ':'';
                }

                if (count($alterTranslation) == 1) {
                    $message = '<p>'
                        . \Yii::t('app', 'Current content is available in this language',['lang' => $links])
                        . '</p>';
                } else {
                    $message = '<p>'
                        . \Yii::t('app', 'Current content is available in these languages',['lang' => $links])
                        . '</p>';
                }
                $message = $alert . $message;
            } else {
                $message = Html::tag('div', \Yii::t('app', 'This content is empty!'), ['class' => 'alert alert-info']);
            }
            return $message;
        } else {
            return Html::decode($translation['content']);
        }
    }

    ###########################

    public function isForLanguage($id): bool
    {
        return $this->lang_id == $id;
    }

    ##########################################################

    public function getText(): ActiveQuery
    {
        return $this->hasOne(Text::class, ['id' => 'parent_id']);
    }

    ###########################################################

    public static function tableName(): string
    {
        return '{{%text_text_translations}}';
    }

//    public function behaviors(): array
//    {
//        return [
//            \abdualiym\text\entities\behaviors\MetaBehavior::className(),
//        ];
//    }

    public function behaviors()
    {
        return [
            'slug' => [
                'class' => 'Zelenin\yii\behaviors\Slug',
                'slugAttribute' => 'slug',
                'attribute' => 'title',
                // optional params
                'ensureUnique' => true,
                'replacement' => '-',
                'lowercase' => true,
                'immutable' => false,
                // If intl extension is enabled, see http://userguide.icu-project.org/transforms/general.
                'transliterateOptions' => 'Russian-Latin/BGN; Any-Latin; Latin-ASCII; NFD; [:Nonspacing Mark:] Remove; NFC;'
            ]
        ];
    }

}