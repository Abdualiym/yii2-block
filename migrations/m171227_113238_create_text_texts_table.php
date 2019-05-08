<?php

use yii\db\Migration;

/**
 * Handles the creation of table `text_texts`.
 */
class m171227_113238_create_text_texts_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';

        $this->createTable('{{%text_texts}}', [
            'id' => $this->primaryKey(),
            'category_id' => $this->integer()->defaultValue(null),
            'is_article' => $this->boolean()->notNull()->defaultValue(true), // <- delete row, if page => category_id=NULL :)
            'status' => $this->smallInteger()->notNull(),
            'date' => $this->integer()->unsigned()->notNull(),
            'photo' => $this->string()->defaultValue('0'),
            'views_count' => $this->integer()->unsigned()->notNull()->defaultValue(0),
            'created_at' => $this->integer()->unsigned()->notNull(),
            'created_by' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->unsigned()->notNull(),
            'updated_by' => $this->integer()->notNull(),
        ], $tableOptions);

        $this->createIndex('{{%index-text_texts-status}}', '{{%text_texts}}', 'status');

        $this->createIndex('{{%index-text_texts-date}}', '{{%text_texts}}', 'date');

        $this->createIndex('{{%index-text_texts-created_by}}', '{{%text_texts}}', 'created_by');
        $this->addForeignKey('{{%fkey-text_texts-created_by}}', '{{%text_texts}}', 'created_by', '{{%users}}', 'id', 'RESTRICT', 'RESTRICT');

        $this->createIndex('{{%index-text_texts-updated_by}}', '{{%text_texts}}', 'updated_by');
        $this->addForeignKey('{{%fkey-text_texts-updated_by}}', '{{%text_texts}}', 'updated_by', '{{%users}}', 'id', 'RESTRICT', 'RESTRICT');

        $this->createIndex('{{%idx-text_texts-category_id}}', '{{%text_texts}}', 'category_id');
        $this->addForeignKey('{{%fk-text_texts-category_id}}', '{{%text_texts}}', 'category_id', '{{%text_categories}}', 'id', 'RESTRICT', 'RESTRICT');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('{{%text_texts}}');
    }
}
