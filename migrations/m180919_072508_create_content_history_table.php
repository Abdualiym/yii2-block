<?php

use yii\db\Migration;

/**
 * Handles the creation of table `content_history`.
 */
class m180919_072508_create_content_history_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';

        $this->createTable('content_history', [
            'id' => $this->primaryKey(),
            'info' => 'MEDIUMTEXT',
            'created_by' => $this->integer()->notNull(),
            'updated_by' => $this->integer()->notNull(),
            'created_at' => $this->integer()->unsigned()->notNull(),
            'updated_at' => $this->integer()->unsigned()->notNull(),
        ], $tableOptions);

        $this->createIndex('{{%index-content_history-created_at}}', '{{%content_history}}', 'created_at');

        $this->createIndex('{{%index-content_history-created_by}}', '{{%content_history}}', 'created_by');
        $this->addForeignKey('{{%fkey-content_history-created_by}}', '{{%content_history}}', 'created_by', '{{%users}}', 'id', 'RESTRICT', 'RESTRICT');

        $this->createIndex('{{%index-content_history-updated_by}}', '{{%content_history}}', 'updated_by');
        $this->addForeignKey('{{%fkey-content_history-updated_by}}', '{{%content_history}}', 'updated_by', '{{%users}}', 'id', 'RESTRICT', 'RESTRICT');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('content_history');
    }
}
