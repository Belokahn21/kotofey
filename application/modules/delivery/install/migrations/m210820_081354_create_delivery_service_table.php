<?php

use yii\db\Migration;

class m210820_081354_create_delivery_service_table extends Migration
{
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%delivery_service}}', [
            'id' => $this->primaryKey(),
            'is_active' => $this->boolean()->defaultValue(1),
            'sort' => $this->integer()->defaultValue(500),
            'name' => $this->string(),
            'code' => $this->string(),
            'description' => $this->string(),
            'media_id' => $this->integer(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ], $tableOptions);
    }

    public function safeDown()
    {
        $this->dropTable('{{%delivery_service}}');
    }
}
