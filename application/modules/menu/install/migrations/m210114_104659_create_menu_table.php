<?php

use yii\db\Migration;

class m210114_104659_create_menu_table extends Migration
{
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';

        $this->createTable('{{%menu}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'is_active' => $this->string()->notNull(),
            'sort' => $this->string()->defaultValue(500),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ], $tableOptions);
    }

    public function safeDown()
    {
        $this->dropTable('{{%menu}}');
    }
}
