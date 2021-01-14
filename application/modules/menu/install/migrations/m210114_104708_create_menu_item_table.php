<?php

use yii\db\Migration;

class m210114_104708_create_menu_item_table extends Migration
{
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';

        $this->createTable('{{%menu_item}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(),
            'parent_id' => $this->integer(),
            'is_active' => $this->integer(),
            'menu_id' => $this->integer()->notNull(),
            'sort' => $this->integer()->defaultValue(500),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ], $tableOptions);

        $this->createIndex('idx-menu_item-menu-menu_id', '{{%menu_item}}', 'menu_id');
        $this->addForeignKey('fk-menu_item-menu-menu_id', '{{%menu_item}}', 'menu_id', '{{%menu}}', 'id', 'CASCADE', 'CASCADE');
    }

    public function safeDown()
    {
        $this->dropTable('{{%menu_item}}');
    }
}
