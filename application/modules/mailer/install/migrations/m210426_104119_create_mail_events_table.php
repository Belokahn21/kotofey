<?php

use yii\db\Migration;

class m210426_104119_create_mail_events_table extends Migration
{
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';

        $this->createTable('{{%mail_events}}', [
            'id' => $this->primaryKey(),
            'is_active' => $this->boolean()->defaultValue(true),
            'sort' => $this->integer()->defaultValue(500),
            'name' => $this->string(128)->notNull(),
            'code' => $this->string()->notNull(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ], $tableOptions);
    }

    public function safeDown()
    {
        $this->dropTable('{{%mail_events}}');
    }
}
