<?php

use yii\db\Migration;

class m210512_092952_create_order_tracking_table extends Migration
{
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%order_tracking}}', [
            'id' => $this->primaryKey(),
            'is_active' => $this->boolean()->defaultValue(true),
            'order_id' => $this->integer()->notNull(),
            'ident_key' => $this->string(250),
            'service_id' => $this->string(250),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ], $tableOptions);
    }

    public function safeDown()
    {
        $this->dropTable('{{%order_tracking}}');
    }
}
