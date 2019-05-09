<?php

namespace abdualiym\block\services;


use abdualiym\block\entities\Category;
use abdualiym\block\forms\CategoryForm;
use abdualiym\block\repositories\CategoryRepository;
use abdualiym\block\repositories\CategoryTranslationRepository;
use yii\helpers\VarDumper;

class CategoryManageService
{
    private $categories;
    private $transaction;

    public function __construct(
        CategoryRepository $categories,
        TransactionManager $transaction
    )
    {
        $this->categories = $categories;
        $this->transaction = $transaction;
    }

    /**
     * @param CategoryForm $form
     * @return Category
     */
    public function create(CategoryForm $form): Category
    {
        $category = Category::create($form->feed_with_image,$form->photo);

        foreach ($form->translations as $translation) {
            $category->setTranslation($translation->lang_id, $translation->name, $translation->title, $translation->description, $translation->meta);
        }

        $this->categories->save($category);

        return $category;
    }

    public function edit($id, CategoryForm $form)
    {
        $category = $this->categories->get($id);

        $category->edit($form->feed_with_image,$form->photo);

        foreach ($form->translations as $translation) {
            $category->setTranslation($translation->lang_id, $translation->name, $translation->title, $translation->description, $translation->meta);
        }

        $this->categories->save($category);
    }

    public function activate($id)
    {
        $category = $this->categories->get($id);
        $category->activate();
        $this->categories->save($category);
    }

    public function draft($id)
    {
        $category = $this->categories->get($id);
        $category->draft();
        $this->categories->save($category);
    }

    public function remove($id)
    {
        $category = $this->categories->get($id);
        $this->categories->remove($category);
    }
}