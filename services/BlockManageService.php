<?php

namespace abdualiym\block\services;


use abdualiym\block\entities\Block;
use abdualiym\block\repositories\BlockRepository;
use abdualiym\block\entities\Text;
use abdualiym\block\forms\PhotosForm;
use abdualiym\block\forms\BlockForm;
use abdualiym\block\repositories\TextRepository;
use abdualiym\block\repositories\TextTranslationRepository;

class BlockManageService
{
    private $textTranslations;
    private $blocks;
    private $transaction;

    public function __construct(
        BlockRepository $blocks,
        TransactionManager $transaction
    )
    {
        $this->texts = $blocks;
        $this->transaction = $transaction;
    }

    /**
     * @param TextForm $form
     * @return Text
     */
    public function create(BlockForm $block): Block
    {
        $block = Text::create($block->category_id, $block->date);

        foreach ($block->translations as $translation) {
            $block->setTranslation($translation->lang_id, $translation->title, $translation->description, $translation->content, $translation->meta);
        }

        foreach ($block->photos->files as $file) {
            $block->addPhoto($file);
        }

        $this->texts->save($block);

        return $block;
    }

    public function edit($id, TextForm $form)
    {
        $text = $this->texts->get($id);

        $text->edit(
            $form->category_id,
            $form->date
        );

        foreach ($form->translations as $translation) {
            $text->setTranslation($translation->lang_id, $translation->title, $translation->description, $translation->content, $translation->meta);
        }

        $this->texts->save($text);
    }

    ##########     Status     ##########

    public function activate($id)
    {
        $text = $this->texts->get($id);
        $text->activate();
        $this->texts->save($text);
    }

    public function draft($id)
    {
        $text = $this->texts->get($id);
        $text->draft();
        $this->texts->save($text);
    }

    ##########     Photos     ##########

    public function addPhotos($id, PhotosForm $form)
    {
        $text = $this->texts->get($id);
        foreach ($form->files as $file) {
            $text->addPhoto($file);
        }
        $this->texts->save($text);
    }

    public function movePhotoUp($id, $photoId)
    {
        $text = $this->texts->get($id);
        $text->movePhotoUp($photoId);
        $this->texts->save($text);
    }

    public function movePhotoDown($id, $photoId)
    {
        $text = $this->texts->get($id);
        $text->movePhotoDown($photoId);
        $this->texts->save($text);
    }

    public function removePhoto($id, $photoId)
    {
        $text = $this->texts->get($id);
        $text->removePhoto($photoId);
        $this->texts->save($text);
    }

    public function remove($id)
    {
        $text = $this->texts->get($id);
        $this->texts->remove($text);
    }
}