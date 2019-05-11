# yii2-block extension

The extension allows manage html content block.

## Installation

- Install with composer:

```bash
composer require abdualiym/yii2-block
```

- **After composer install** run console command for create tables:

```bash
php yii migrate/up --migrationPath=@vendor/abdualiym/yii2-block/migrations
```

- Setup in common config storage and language configurations

```php
'modules' => [
    'block' => [
        'class' => '@abdualiym\block\Module',
        'storageRoot' => $params['staticPath'],
        'storageHost' => $params['staticHostInfo'],
        'languages' => [
            0 => 'Русский', // default language
            1 => 'English',
            2 => 'O`zbek tili',
        ]
    ],
],
```