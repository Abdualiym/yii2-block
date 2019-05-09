<?php

namespace abdualiym\block\repositories;


use abdualiym\block\entities\TextMetaFields;

class TextMetaFieldRepository
{
    public function get($id): TextMetaFields
    {
        if (!$meta = TextMetaFields::findOne($id)) {
            throw new NotFoundException('Text Meta Field is not found.');
        }
        return $meta;
    }

    public function save(TextMetaFields $meta)
    {
        if (!$meta->save()) {
            throw new \RuntimeException('Saving error.');
        }
    }

    public function remove(TextMetaFields $meta)
    {
        if (!$meta->delete()) {
            throw new \RuntimeException('Removing error.');
        }
    }
}