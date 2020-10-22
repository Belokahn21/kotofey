<?php

use yii\db\Migration;

class m201022_035519_014_create_table_orders_items extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%orders_items}}', [
            'id' => $this->primaryKey(),
            'order_id' => $this->integer(),
            'product_id' => $this->integer(),
            'count' => $this->integer(),
            'purchase' => $this->integer(),
            'price' => $this->integer(),
            'discount_price' => $this->integer(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
            'name' => $this->string()->comment('Название того что продали'),
            'weight' => $this->integer(),
            'image' => $this->string(),
        ], $tableOptions);

        $this->createIndex('idx-order_items-orders-user_id', '{{%orders_items}}', 'order_id');
        $this->addForeignKey('fk-order_items-orders-user_id', '{{%orders_items}}', 'order_id', '{{%orders}}', 'id', 'CASCADE', 'CASCADE');
    }

    public function down()
    {
        $this->dropTable('{{%orders_items}}');
    }
}
