<?php

use yii\db\Migration;

class m210616_082204_order_mail_history extends Migration
{
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%order_mail_history}}', [
            'id' => $this->primaryKey(),
            'order_id' => $this->integer()->notNull(),
            'event_id' => $this->integer()->notNull(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ], $tableOptions);
    }

    public function safeDown()
    {
        $this->dropTable('{{%order_mail_history}}');
    }
}
