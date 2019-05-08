<?php

namespace abdualiym\text\repositories;


use abdualiym\text\entities\Category;

class CategoryRepository
{
    public function get($id): Category
    {
        if (!$category = Category::findOne($id)) {
            throw new NotFoundException('Contact is not found.');
        }
        return $category;
    }

    public function save(Category $category)
    {
        if (!$category->save()) {
            throw new \RuntimeException('Saving error.');
        }
    }

    public function remove(Category $category)
    {
        if (!$category->delete()) {
            throw new \RuntimeException('Removing error.');
        }
    }
}