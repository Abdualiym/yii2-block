<?php

namespace abdualiym\text\helpers;

use abdualiym\text\entities\Text;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

class TextHelper
{
    public static function statusList(): array
    {
        return [
            Text::STATUS_DRAFT => \Yii::t('app','Draft'),
            Text::STATUS_ACTIVE => \Yii::t('app','Active'),
        ];
    }

    public static function statusName($status): string
    {
        return ArrayHelper::getValue(self::statusList(), $status);
    }

    public static function statusLabel($status): string
    {
        switch ($status) {
            case Text::STATUS_DRAFT:
                $class = 'label label-default';
                break;
            case Text::STATUS_ACTIVE:
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