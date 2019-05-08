<?php

namespace abdualiym\blocks;

use yii\base\BootstrapInterface;


class Bootstrap implements BootstrapInterface
{
    /**
     * @inheritdoc
     */
    public function bootstrap($app)
    {
        // Add module I18N category.
        if (!isset($app->i18n->translations['blocks']) && !isset($app->i18n->translations['blocks*'])) {
            $app->i18n->translations['blocks'] = [
                'class' => 'yii\i18n\PhpMessageSource',
                'basePath' => '@abdualiym/blocks/messages',
                'sourceLanguage' => 'en',
                'forceTranslation' => true,
            ];
        }
    }
}
