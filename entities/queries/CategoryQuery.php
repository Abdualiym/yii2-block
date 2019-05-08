<?php

namespace abdualiym\text\entities\queries;

use abdualiym\text\entities\Category;
use yii\db\ActiveQuery;

class CategoryQuery extends ActiveQuery
{
    /**
     * @param null $alias
     * @return $this
     */
    public function active($alias = null)
    {
        return $this->andWhere([
            ($alias ? $alias . '.' : '') . 'status' => Category::STATUS_ACTIVE,
        ]);
    }
}