<?php

use yii\db\Migration;

class m210401_102641_create_module_settings_table extends Migration
{
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%module_settings}}', [
            'id' => $this->primaryKey(),
            'module_id' => $this->string(255),
            'param_name' => $this->string(255),
            'param_value' => $this->string(255),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ], $tableOptions);
    }

    public function safeDown()
    {
        $this->dropTable('{{%module_settings}}');
    }
}
