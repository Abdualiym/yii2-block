<?php

use yii\db\Migration;

/**
 * Class m180207_115707_alter_category_description_column
 */
class m180207_115707_alter_category_description_column extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->alterColumn('{{%text_category_translations}}', 'description', 'MEDIUMTEXT');
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        echo "m180207_115707_alter_category_description_column cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180207_115707_alter_category_description_column cannot be reverted.\n";

        return false;
    }
    */
}
