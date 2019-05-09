<?php

namespace abdualiym\block\repositories;


use abdualiym\Block\entities\Block;

class BlockRepository
{
    public function get($id): Block
    {
        if (!$block = Block::findOne($id)) {
            throw new NotFoundException('Block is not found.');
        }
        return $block;
    }

    public function save(Block $Block)
    {
        if (!$block->save()) {
            throw new \RuntimeException('Saving error.');
        }
    }

    public function remove(Block $Block)
    {
        if (!$block->delete()) {
            throw new \RuntimeException('Removing error.');
        }
    }
}