<?php

use yii\db\Migration;

/**
 * Class m180516_054523_alter_table_add_photo_column_text_categories
 */
class m180516_054523_alter_table_add_photo_column_text_categories extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->addColumn('{{%text_categories}}', 'photo', $this->string());
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->dropColumn('{{%text_categories}}', 'photo');
    }
}
