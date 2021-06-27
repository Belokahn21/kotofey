<?php

use yii\db\Migration;

class m210627_020922_create_vendors_manager_table extends Migration
{
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }

        $this->dropTable('{{%vendor_manager}}');

        $this->createTable('{{%vendor_manager}}', [
            'id' => $this->primaryKey(),
            'is_active' => $this->boolean()->defaultValue(true),
            'sort' => $this->integer()->defaultValue(500),
            'vendor_id' => $this->integer(),
            'name' => $this->string(),
            'method_buy' => $this->string(),
            'phone' => $this->bigInteger(),
            'email' => $this->string(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ], $tableOptions);
    }

    public function safeDown()
    {
        $this->dropTable('{{%vendors_manager}}');
    }
}
