<?php

use yii\db\Migration;

class m200119_140308_create_change_tables_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('{{%order_date}}', [
            'id' => $this->primaryKey(),
            'order_id' => $this->integer()->notNull(),
            'date' => $this->string(255)->notNull(),
            'time' => $this->string(255)->notNull(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ]);


        $this->dropColumn('{{%orders}}', 'date');
        $this->dropColumn('{{%orders}}', 'time');

        $this->renameTable('order_billing', 'orders_billing');
    }

    public function safeDown()
    {
        $this->dropTable('{{%change_tables}}');
    }
}
