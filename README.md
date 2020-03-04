# yii2-block extension

The extension allows manage html content block.

## Installation

- Install with composer:

```bash
composer require abdualiym/yii2-block "^1.0"
```

- **After composer install** run console command for create tables:

```bash
php yii migrate/up --migrationPath=@vendor/abdualiym/yii2-block/migrations
```

- Setup in common config storage and language configurations.
> language indexes related with database columns.

> Admin panel tabs render by array values order 

```php
'modules' => [
    'block' => [
        'class' => '@abdualiym\block\Module',
        'storageRoot' => $params['staticPath'],
        'storageHost' => $params['staticHostInfo'],
        'thumbs' => [ // 'sm' and 'md' keys are reserved
            'admin' => ['width' => 128, 'height' => 128],
            'thumb' => ['width' => 320, 'height' => 320],
        ],
        'languages' => [
            'ru' => [
                'id' => 0,
                'name' => 'Русский',
            ],
            'en' => [
                'id' => 1,
                'name' => 'English',
            ],
        ],
    ],
],
```

##In admin panel add belove links for manage blocks
> for manage blocks:
```
/block/block/index
```
> links for content manager update/view each block uses `slug` attribute 
```
/block/block/view?slug=slug-value
/block/block/update?slug=slug-value
```

> CKEditor use Elfinder plugin for save files and images. Refer [Elfinder readme](https://github.com/MihailDev/yii2-elfinder) for proper configuration

###Examples

Extension registers next language arrays to Yii::$app->params[] for use in views:
```php
\Yii::$app->params['cms']['languageIds'][$prefix] = $language['id'];
[
    'en' => 2,
    'ru' => 1,
    ...
]

\Yii::$app->params['cms']['languages'][$prefix] = $language['name'];
[
    'en' => 'English',
    ...
]


\Yii::$app->params['cms']['languages2'][$language['id']] = $language['name'];
[
    2 => 'English',
    ...
]
```