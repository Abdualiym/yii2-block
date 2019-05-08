<?php

use yii\db\Migration;

/**
 * Handles the creation of table `text_text_translations`.
 */
class m171227_125243_create_text_text_translations_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';

        $this->createTable('{{%text_text_translations}}', [
            'id' => $this->primaryKey(),
            'lang_id' => $this->integer()->defaultValue(null),
            'parent_id' => $this->integer()->notNull(),
            'title' => $this->string()->notNull(),
            'slug' => $this->string()->notNull(),
            'description' => $this->text(),
            'content' => 'MEDIUMTEXT',
            'meta_json' => 'JSON NOT NULL',
        ], $tableOptions);

        $this->createIndex('{{%idx-text_text_translations-parent_id}}', '{{%text_text_translations}}', 'parent_id');
        $this->addForeignKey('{{%fk-text_text_translations-parent_id}}', '{{%text_text_translations}}', 'parent_id', '{{%text_texts}}', 'id', 'CASCADE', 'RESTRICT');

        $this->createIndex('{{%idx-text_text_translations-slug}}', '{{%text_text_translations}}', 'slug', true);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('{{%text_text_translations}}');
    }
}
