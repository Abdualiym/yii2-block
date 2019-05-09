<?php

namespace abdualiym\block\services;


use abdualiym\block\entities\Text;
use abdualiym\block\entities\TextMetaFields;
use abdualiym\block\forms\TextForm;
use abdualiym\block\forms\TextMetaFieldForm;
use abdualiym\block\repositories\MetaFieldRepository;
use abdualiym\block\repositories\TextMetaFieldRepository;
use abdualiym\block\repositories\TextTranslationRepository;
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