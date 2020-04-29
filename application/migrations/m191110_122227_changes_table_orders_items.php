<?php

use yii\db\Migration;

/**
 * Class m191110_122227_changes_table_orders_items
 */
class m191110_122227_changes_table_orders_items extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->renameTable('{{%order_items}}', '{{%orders_items}}');

        $this->renameColumn('{{%orders_items}}', 'orderId', 'order_id');
        $this->renameColumn('{{%orders_items}}', 'productId', 'product_id');
        $this->renameColumn('{{%orders_items}}', 'summ', 'price');

        $this->addColumn('{{%orders_items}}', 'name', $this->string(255)->null()->comment('Название того что продали'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->renameTable('{{%orders_items}}', '{{%order_items}}');

        $this->renameColumn('{{%order_items}}', 'order_id', 'orderId');
        $this->renameColumn('{{%order_items}}', 'product_id', 'productId');
        $this->renameColumn('{{%order_items}}', 'price', 'summ');

        $this->dropColumn('{{%order_items}}', 'name');
        return false;
    }
}
