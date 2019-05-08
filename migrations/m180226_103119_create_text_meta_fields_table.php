<?php

use yii\db\Migration;

/**
 * Handles the creation of table `text_meta_fields`.
 */
class m180226_103119_create_text_meta_fields_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';

        $this->createTable('{{%text_meta_fields}}', [
            'id' => $this->primaryKey(),
            'lang_id' => $this->integer()->defaultValue(null),
            'text_id' => $this->integer()->notNull(),
            'key' => $this->string()->unique()->notNull(),
            'value' => $this->text()->notNull(),
        ], $tableOptions);

        $this->createIndex('{{%idx-text_meta_fields-text_id}}', '{{%text_meta_fields}}', 'text_id');
        $this->addForeignKey('{{%fk-text_meta_fields-text_id}}', '{{%text_meta_fields}}', 'text_id', '{{%text_texts}}', 'id', 'CASCADE', 'RESTRICT');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('{{%text_meta_fields}}');
        return false;
    }
}
