<?php

use yii\db\Migration;

class m210104_171636_create_property_group_table extends Migration
{
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }
        $this->createTable('{{%property_group}}', [
            'id' => $this->primaryKey(),
            'is_active' => $this->boolean()->defaultValue(1),
            'name' => $this->string(255),
            'slug' => $this->string(255),
            'sort' => $this->integer()->defaultValue(500)->notNull(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ], $tableOptions);
    }

    public function safeDown()
    {
        $this->dropTable('{{%property_group}}');
    }
}
