<?php

use yii\db\Migration;

class m201022_035520_056_create_table_discount extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%discount}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer(),
            'count' => $this->float(),
        ], $tableOptions);

        $this->createIndex('idx-user_discount-user_id', '{{%discount}}', 'user_id');
        $this->addForeignKey('fk-user_discount-user_id', '{{%discount}}', 'user_id', '{{%user}}', 'id', 'CASCADE', 'CASCADE');
    }

    public function down()
    {
        $this->dropTable('{{%discount}}');
    }
}
