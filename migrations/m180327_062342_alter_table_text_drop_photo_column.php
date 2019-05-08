<?php

use yii\db\Migration;

/**
 * Class m180327_062342_alter_table_text_drop_photo_column
 */
class m180327_062342_alter_table_text_drop_photo_column extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->dropColumn('{{%text_texts}}', 'photo');
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        echo "m180327_062342_alter_table_text_drop_photo_column cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180327_062342_alter_table_text_drop_photo_column cannot be reverted.\n";

        return false;
    }
    */
}
