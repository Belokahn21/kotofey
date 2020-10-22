<?php

use yii\db\Migration;

class m201022_035519_011_create_table_order_date extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%order_date}}', [
            'id' => $this->primaryKey(),
            'order_id' => $this->integer()->notNull(),
            'date' => $this->string()->notNull(),
            'time' => $this->string()->notNull(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ], $tableOptions);

    }

    public function down()
    {
        $this->dropTable('{{%order_date}}');
    }
}
