<?php

use yii\db\Migration;

class m190509_144300_create_yii2_blocks_table extends Migration
{

    public function up()
    {
        $tableOptions = $this->db->driverName === 'mysql' ? 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB' : null;

        $this->createTable('{{%yii2_blocks}}', [
            'id' => $this->primaryKey(),
            'parent_id' => $this->integer(),
            'label' => $this->string()->notNull(),
            'slug' => $this->string()->notNull(),
            'data_type' => $this->integer()->notNull(),
            'data_0' => 'MEDIUMTEXT',
            'data_1' => 'MEDIUMTEXT',
            'data_2' => 'MEDIUMTEXT',
            'data_3' => 'MEDIUMTEXT',
            'created_at' => $this->integer()->unsigned()->notNull(),
            'updated_at' => $this->integer()->unsigned()->notNull(),
        ], $tableOptions);

        $this->createIndex('{{%index-yii2_blocks-slug}}', '{{%yii2_blocks}}', 'slug');
        $this->createIndex('{{%index-yii2_blocks-updated_at}}', '{{%yii2_blocks}}', 'updated_at');
    }


    public function down()
    {
        $this->dropTable('{{%yii2_blocks}}');
    }
}
