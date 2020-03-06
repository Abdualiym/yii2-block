<?php

namespace abdualiym\block\helpers;

class Type
{

    const STRINGS = 1;
    const STRING_COMMON = 2;
    const IMAGES = 11;
    const IMAGE_COMMON = 12;
    const FILES = 15;
    const FILE_COMMON = 16;
    const TEXTS = 21;
    const TEXT_COMMON = 22;


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

    public static function name($key)
    {
        $list = self::list();
        return $list[$key];
    }

    public static function list()
    {
        return [
            self::STRINGS => \Yii::t('block', 'Translateable strings'),
            self::STRING_COMMON => \Yii::t('block', 'Common string'),
            self::TEXTS => \Yii::t('block', 'Translateable texts'),
            self::TEXT_COMMON => \Yii::t('block', 'Common text'),
            self::IMAGES => \Yii::t('block', 'Translateable images'),
            self::IMAGE_COMMON => \Yii::t('block', 'Common image'),
            self::FILES => \Yii::t('block', 'Translateable files'),
            self::FILE_COMMON => \Yii::t('block', 'Common file')
        ];
    }
}
