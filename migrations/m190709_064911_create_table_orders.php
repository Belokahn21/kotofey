<?php

use yii\db\Migration;

class m190709_064911_create_table_orders extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%orders}}', [
            'id' => $this->primaryKey(),
            'user' => $this->integer(),
            'delivery' => $this->integer(),
            'payment' => $this->integer(),
            'paid' => $this->tinyInteger()->notNull(),
            'status' => $this->integer()->notNull(),
            'comment' => $this->text(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ], $tableOptions);

    }

    public function down()
    {
        $this->dropTable('{{%orders}}');
    }
}
