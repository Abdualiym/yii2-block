<?php

namespace abdualiym\block\helpers;

use abdualiym\block\Module;
use yii\behaviors\TimestampBehavior;
use yiidreamteam\upload\FileUploadBehavior;
use yiidreamteam\upload\ImageUploadBehavior;

class Type
{

    const STRINGS = 1;
    const STRING_COMMON = 2;
    const TEXTS = 3;
    const TEXT_COMMON = 4;
    const LINKS = 5;
    const LINK_COMMON = 6;
    const IMAGES = 7;
    const IMAGE_COMMON = 8;
    const FILES = 9;
    const FILE_COMMON = 10;


    public static function config($type): array
    {
        switch ($type) {
            case self::IMAGES:
                return self::imageConfig();
            case self::IMAGE_COMMON:
                return self::imageConfig(true);
            case self::FILES:
                return self::fileConfig();
            case self::FILE_COMMON:
                return self::fileConfig(true);
            default:
                return [];
        };
    }

    private static function imageConfig($common = false)
    {
        $module = Module::getInstance();
        $keys = $module->dataKeys();

        $array = [];
        foreach ($keys as $i => $key) {
            $array[] = [
                'class' => ImageUploadBehavior::className(),
                'attribute' => 'data_' . $key,
                'createThumbsOnRequest' => true,
                'filePath' => $module->storageRoot . '/yii2-block/data/[[attribute_id]]/[[id]].[[extension]]',
                'fileUrl' => $module->storageHost . '/yii2-block/data/[[attribute_id]]/[[id]].[[extension]]',
                'thumbPath' => $module->storageRoot . '/yii2-block/cache/[[attribute_id]]/[[profile]]_[[id]].[[extension]]',
                'thumbUrl' => $module->storageHost . '/yii2-block/cache/[[attribute_id]]/[[profile]]_[[id]].[[extension]]',
                'thumbs' => $module->thumbs
            ];

            if ($common) {
                break;
            }
        }

        return $array;
    }

    private static function fileConfig($common = false)
    {
        $module = Module::getInstance();
        $keys = $module->dataKeys();

        $array = [];
        foreach ($keys as $i => $key) {
            $array[] = [
                'class' => FileUploadBehavior::className(),
                'attribute' => 'data_' . $key,
                'filePath' => '@staticRoot/app/text/[[attribute_text_id]]/[[id]].[[extension]]',
                'fileUrl' => '@staticUrl/app/text/[[attribute_text_id]]/[[id]].[[extension]]',
            ];

            if ($common) {
                break;
            }
        }

        return $array;
    }

    public static function list()
    {
        return [
            self::STRINGS => \Yii::t('block', 'Separate strings'),
            self::STRING_COMMON => \Yii::t('block', 'Common string'),
            self::TEXTS => \Yii::t('block', 'Separate texts'),
            self::TEXT_COMMON => \Yii::t('block', 'Common text'),
            self::LINKS => \Yii::t('block', 'Separate links'),
            self::LINK_COMMON => \Yii::t('block', 'Common link'),
            self::IMAGES => \Yii::t('block', 'Separate images'),
            self::IMAGE_COMMON => \Yii::t('block', 'Common image'),
            self::FILES => \Yii::t('block', 'Separate files'),
            self::FILE_COMMON => \Yii::t('block', 'Common file')
        ];
    }
}