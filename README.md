# yii2-blocks extension

The extension allows manage html content blocks.

## Installation

- Install with composer:

```bash
composer require abdualiym/yii2-blocks
```

- **After composer install** run console command for create tables:

```bash
php yii migrate/up --migrationPath=@vendor/abdualiym/yii2-blocks/migrations
```

- add to backend config file:
```php
'controllerMap' => [
    'blocks' => [
        'class' => 'abdualiym\blocks\controllers\BlocksController',
    ],
],
```

- add to common config file:
```php
'i18n' => [
    'translations' => [
        'blocks' => [
            'class' => 'yii\i18n\PhpMessageSource',
            'basePath' => '@vendor/abdualiym/yii2-blocks/messages',
            'sourceLanguage' => 'en',
            'fileMap' => [
                'blocks' => 'blocks.php',
            ],
        ],
    ]
],

```
