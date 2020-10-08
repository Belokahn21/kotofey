<?php

use yii\db\Migration;

class m191031_042600_030_create_table_todo_list extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%todo_list}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(256)->notNull(),
            'description' => $this->text(),
            'close' => $this->tinyInteger(1)->notNull(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ], $tableOptions);

    }

    public function down()
    {
        $this->dropTable('{{%todo_list}}');
    }
}
