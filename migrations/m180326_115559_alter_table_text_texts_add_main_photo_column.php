<?php

use yii\db\Migration;

/**
 * Class m180326_115559_alter_table_text_texts_add_main_photo_column
 */
class m180326_115559_alter_table_text_texts_add_main_photo_column extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->addColumn('{{%text_texts}}', 'main_photo_id', $this->integer());

        $this->createIndex('{{%idx-text_texts-main_photo_id}}', '{{%text_texts}}', 'main_photo_id');

        $this->addForeignKey('{{%fk-text_texts-main_photo_id}}', '{{%text_texts}}', 'main_photo_id', '{{%text_text_photos}}', 'id', 'SET NULL', 'RESTRICT');
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->dropForeignKey('{{%fk-text_texts-main_photo_id}}', '{{%text_texts}}');

        $this->dropColumn('{{%text_texts}}', 'main_photo_id');
    }
}
