<?php

namespace abdualiym\text\entities\queries;

use abdualiym\text\entities\Text;
use yii\db\ActiveQuery;

class TextQuery extends ActiveQuery
{
    /**
     * @param null $alias
     * @return $this
     */
    public function active($alias = null)
    {
        return $this->andWhere([
            ($alias ? $alias . '.' : '') . 'status' => Text::STATUS_ACTIVE,
        ]);
    }
}