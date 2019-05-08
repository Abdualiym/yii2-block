<?php

use yii\db\Migration;

/**
 * Class m180324_073639_create_table_text_photos
 */
class m180324_073639_create_table_text_photos extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';

        $this->createTable('{{%text_text_photos}}', [
            'id' => $this->primaryKey(),
            'text_id' => $this->integer()->notNull(),
            'file' => $this->string()->notNull(),
            'sort' => $this->integer()->notNull(),
        ], $tableOptions);

        $this->createIndex('{{%idx-text_text_photos-text_id}}', '{{%text_text_photos}}', 'text_id');

        $this->addForeignKey('{{%fk-text_text_photos-text_id}}', '{{%text_text_photos}}', 'text_id', '{{%text_texts}}', 'id', 'CASCADE', 'RESTRICT');
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->dropTable('{{%text_text_photos}}');
    }
}
