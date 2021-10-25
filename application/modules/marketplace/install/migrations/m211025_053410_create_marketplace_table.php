<?php

use yii\db\Migration;

class m211025_053410_create_marketplace_table extends Migration
{
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        $this->createTable('{{%marketplace}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->null(),
            'slug' => $this->string()->null(),
            'is_active' => $this->boolean()->defaultValue(1),
            'sort' => $this->integer()->defaultValue(500),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ], $tableOptions);
    }

    public function safeDown()
    {
        $this->dropTable('{{%marketplace}}');
    }
}
