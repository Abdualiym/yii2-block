<?php

use yii\db\Migration;

/**
 * Handles the creation of table `text_category_translations`.
 */
class m171227_113229_create_text_category_translations_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';

        $this->createTable('{{%text_category_translations}}', [
            'id' => $this->primaryKey(),
            'lang_id' => $this->integer()->notNull(),
            'parent_id' => $this->integer()->notNull(),
            'name' => $this->string()->notNull(),
            'slug' => $this->string()->notNull(),
            'title' => $this->string(),
            'description' => 'MEDIUMTEXT',
            'meta_json' => 'JSON NOT NULL',
        ], $tableOptions);

        $this->createIndex('{{%idx-text_category_translations-parent_id}}', '{{%text_category_translations}}', 'parent_id');
        $this->addForeignKey('{{%fk-text_category_translations-parent_id}}', '{{%text_category_translations}}', 'parent_id', '{{%text_categories}}', 'id', 'CASCADE', 'RESTRICT');

        $this->createIndex('{{%idx-text_category_translations-slug}}', '{{%text_category_translations}}', 'slug', true);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('{{%text_category_translations}}');
    }
}
