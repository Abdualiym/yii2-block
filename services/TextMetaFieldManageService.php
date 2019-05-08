<?php

namespace abdualiym\text\services;


use abdualiym\text\entities\Text;
use abdualiym\text\entities\TextMetaFields;
use abdualiym\text\forms\TextForm;
use abdualiym\text\forms\TextMetaFieldForm;
use abdualiym\text\repositories\MetaFieldRepository;
use abdualiym\text\repositories\TextMetaFieldRepository;
use abdualiym\text\repositories\TextTranslationRepository;
use yii\helpers\VarDumper;

class TextMetaFieldManageService
{
    private $metaFields;
    private $transaction;

    public function __construct(
        TextMetaFieldRepository $metaFields,
        TransactionManager $transaction
    )
    {
        $this->metaFields = $metaFields;
        $this->transaction = $transaction;
    }

    /**
     * @param TextMetaFieldForm $form
     * @return Text
     */
    public function create(TextMetaFieldForm $form): TextMetaFields
    {
        $meta = TextMetaFields::create($form->text_id, $form->lang_id, $form->key, $form->value);

        $this->metaFields->save($meta);

        return $meta;
    }

    public function edit($id, TextMetaFieldForm $form)
    {
        $meta = $this->metaFields->get($id);

        $meta->edit(
            $form->text_id,
            $form->lang_id,
            $form->key,
            $form->value
        );

        $this->metaFields->save($meta);
    }

    public function remove($id)
    {
        $meta = $this->metaFields->get($id);
        $this->metaFields->remove($meta);
    }
}