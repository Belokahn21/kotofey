<?php

use yii\db\Migration;

class m201022_035519_013_create_table_orders_billing extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%orders_billing}}', [
            'id' => $this->primaryKey(),
            'order_id' => $this->integer(),
            'user_billing_id' => $this->integer(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ], $tableOptions);

    }

    public function down()
    {
        $this->dropTable('{{%orders_billing}}');
    }
}
