<?php

use yii\db\Migration;

class m210117_150155_create_notify_admission_table extends Migration
{
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';

        $this->createTable('{{%notify_admission}}', [
            'id' => $this->primaryKey(),
            'is_active' => $this->boolean()->defaultValue(1),
            'email' => $this->string()->notNull(),
            'product_id' => $this->integer()->notNull(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ], $tableOptions);
    }

    public function safeDown()
    {
        $this->dropTable('{{%notify_admission}}');
    }
}
