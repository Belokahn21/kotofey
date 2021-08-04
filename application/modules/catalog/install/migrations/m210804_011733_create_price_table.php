<?php

use yii\db\Migration;

class m210804_011733_create_price_table extends Migration
{
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%price}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(),
            'is_active' => $this->boolean()->defaultValue(1),
            'is_main' => $this->boolean()->defaultValue(1),
            'sort' => $this->integer(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ], $tableOptions);
    }

    public function safeDown()
    {
        $this->dropTable('{{%price}}');
    }
}
