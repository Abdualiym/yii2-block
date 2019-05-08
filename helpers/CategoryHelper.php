<?php

namespace abdualiym\text\helpers;

use abdualiym\text\entities\Category;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

class CategoryHelper
{
    public static function statusList(): array
    {
        return [
            Category::STATUS_DRAFT => \Yii::t('app', 'Draft'),
            Category::STATUS_ACTIVE => \Yii::t('app', 'Active'),
        ];
    }

    public static function statusName($status): string
    {
        return ArrayHelper::getValue(self::statusList(), $status);
    }

    public static function statusLabel($status): string
    {
        switch ($status) {
            case Category::STATUS_DRAFT:
                $class = 'label label-default';
                break;
            case Category::STATUS_ACTIVE:
                $class = 'label label-success';
                break;
            default:
                $class = 'label label-default';
        }

        return Html::tag('span', ArrayHelper::getValue(self::statusList(), $status), [
            'class' => $class,
        ]);
    }
}