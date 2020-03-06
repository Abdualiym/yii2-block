<?php

namespace abdualiym\block\entities;

use yii\db\ActiveRecord;

/**
 * @property int $id
 * @property int $created_at
 * @property int $updated_at
 */
abstract class BlockActiveRecord extends ActiveRecord
{
    public static function tableName()
    {
        return 'abdualiym_block_blocks';
    }

    abstract public function getData($key);

    abstract public function getFormField($form, $key, $language);
}
