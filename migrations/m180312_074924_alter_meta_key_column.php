<?php

use yii\db\Migration;

/**
 * Class m180312_074924_alter_meta_key_column
 */
class m180312_074924_alter_meta_key_column extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->dropColumn('text_meta_fields', 'key');
        $this->addColumn('text_meta_fields', 'key', $this->string()->notNull());
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        echo "m180312_074924_alter_meta_key_column cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180312_074924_alter_meta_key_column cannot be reverted.\n";

        return false;
    }
    */
}
