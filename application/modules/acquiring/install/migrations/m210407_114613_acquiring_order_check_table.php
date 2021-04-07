<?php

use yii\db\Migration;

class m210407_114613_acquiring_order_check_table extends Migration
{
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }
        $this->createTable('{{%acquiring_order_check}}', [
            'id' => $this->primaryKey(),
            'order_id' => $this->integer()->notNull(),
            'identifier_id' => $this->string(255)->notNull()->comment('ID чека'),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ], $tableOptions);
    }

    public function safeDown()
    {
    }

}
