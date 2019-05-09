<?php

namespace abdualiym\block\repositories;


use abdualiym\block\entities\Text;

class TextRepository
{
    public function get($id): Text
    {
        if (!$text = Text::findOne($id)) {
            throw new NotFoundException('Text is not found.');
        }
        return $text;
    }

    public function save(Text $text)
    {
        if (!$text->save()) {
            throw new \RuntimeException('Saving error.');
        }
    }

    public function remove(Text $text)
    {
        if (!$text->delete()) {
            throw new \RuntimeException('Removing error.');
        }
    }
}