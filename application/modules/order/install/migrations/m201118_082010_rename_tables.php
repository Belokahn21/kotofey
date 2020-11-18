<?php

use yii\db\Migration;

class m201118_082010_rename_tables extends Migration
{
    public function safeUp()
    {

        $this->dropForeignKey('fk-order_items-orders-user_id', '{{%orders_items}}');
        $this->dropIndex('idx-order_items-orders-user_id', '{{%orders_items}}');

        $this->renameTable('orders', 'order');

        $this->createIndex('idx-order_items-order-user_id', '{{%orders_items}}', 'order_id');
        $this->addForeignKey('fk-order_items-order-user_id', '{{%orders_items}}', 'order_id', '{{%order}}', 'id', 'CASCADE', 'CASCADE');
    }

    public function safeDown()
    {
        $this->renameTable('order', 'orders');
    }

}
