<?php

namespace abdualiym\block;

use yii\base\BootstrapInterface;


class Bootstrap implements BootstrapInterface
{
    /**
     * @inheritdoc
     */
    public function bootstrap($app)
    {
        // Add module I18N category.
        if (!isset($app->i18n->translations['block']) && !isset($app->i18n->translations['block*'])) {
            $app->i18n->translations['block'] = [
                'class' => 'yii\i18n\PhpMessageSource',
                'basePath' => __DIR__ . '/messages',
                'sourceLanguage' => 'en',
                'forceTranslation' => true,
            ];
        }

//        $app->controllerMap['block'] = [
//            'class' => 'abdualiym\block\controllers\BlockController',
//        ];
    }
}
