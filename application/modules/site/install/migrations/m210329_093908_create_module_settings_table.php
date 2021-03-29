<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%module_settings}}`.
 */
class m210329_093908_create_module_settings_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('{{%module_settings}}', [
            'id' => $this->primaryKey(),
            'module_id' => $this->string(255),
            'param_name' => $this->string(),
            'param_value' => $this->string(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ]);
    }

    public function safeDown()
    {
        $this->dropTable('{{%module_settings}}');
    }
}
