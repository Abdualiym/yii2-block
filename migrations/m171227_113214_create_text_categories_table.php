<?php

use yii\db\Migration;

/**
 * Handles the creation of table `text_categories`.
 */
class m171227_113214_create_text_categories_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';

        $this->createTable('{{%text_categories}}', [
            'id' => $this->primaryKey(),
            'created_at' => $this->integer()->unsigned()->notNull(),
            'created_by' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->unsigned()->notNull(),
            'updated_by' => $this->integer()->notNull(),
            'feed_with_image' => $this->boolean()->notNull()->defaultValue(true),
            'status' => $this->smallInteger()->notNull(),
        ], $tableOptions);

        $this->createIndex('{{%index-text_categories-status}}', '{{%text_categories}}', 'status');

        $this->createIndex('{{%index-text_categories-created_by}}', '{{%text_categories}}', 'created_by');
        $this->addForeignKey('{{%fkey-text_categories-created_by}}', '{{%text_categories}}', 'created_by', '{{%users}}', 'id', 'RESTRICT', 'RESTRICT');

        $this->createIndex('{{%index-text_categories-updated_by}}', '{{%text_categories}}', 'updated_by');
        $this->addForeignKey('{{%fkey-text_categories-updated_by}}', '{{%text_categories}}', 'updated_by', '{{%users}}', 'id', 'RESTRICT', 'RESTRICT');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('{{%text_categories}}');
    }
}
