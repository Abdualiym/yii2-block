<?php

use yii\db\Migration;

/**
 * Class m200305_121443_create_block_blocks_table
 */
class m200305_121443_create_block_blocks_table extends Migration
{

    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%abdualiym_block_blocks}}', [
            'id' => $this->primaryKey(),
            'category_id' => $this->integer()->notNull(),
            'sort' => $this->tinyInteger()->notNull(),
            'slug' => $this->string()->notNull(),
            'label' => $this->string()->notNull(),
            'size' => $this->integer()->notNull(),
            'type' => $this->integer()->notNull(),
            'data_0' => $this->text(),
            'data_1' => $this->text(),
            'data_2' => $this->text(),
            'data_3' => $this->text(),
            'created_at' => $this->integer()->unsigned()->notNull(),
            'updated_at' => $this->integer()->unsigned()->notNull(),
        ], $tableOptions);

        $this->createIndex('{{%index-abdualiym_block_blocks-slug}}', '{{%abdualiym_block_blocks}}', 'slug');
        $this->createIndex('{{%index-abdualiym_block_blocks-updated_at}}', '{{%abdualiym_block_blocks}}', 'updated_at');

        $this->createIndex('index-abdualiym_block_blocks-category_id', 'abdualiym_block_blocks', 'category_id');
        $this->addForeignKey('fkey-abdualiym_block_blocks-category_id', 'abdualiym_block_blocks', 'category_id', 'abdualiym_block_categories', 'id', 'RESTRICT', 'RESTRICT');
    }

    public function safeDown()
    {
        $this->dropTable('abdualiym_block_blocks');
    }

}
