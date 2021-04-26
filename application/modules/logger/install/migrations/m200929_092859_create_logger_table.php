<?php

use yii\db\Migration;

class m200929_092859_create_logger_table extends Migration
{
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }
        $this->createTable('{{%logger}}', [
            'id' => $this->primaryKey(),
            'message' => $this->text()->notNull(),
            'uniqCode' => $this->integer()->notNull(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer()
        ], $tableOptions);
    }

    public function safeDown()
    {
        $this->dropTable('{{%logger}}');
    }
}
