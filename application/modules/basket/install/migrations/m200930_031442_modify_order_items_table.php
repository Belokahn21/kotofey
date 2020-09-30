<?php

use yii\db\Migration;

class m200930_031442_modify_order_items_table extends Migration
{
    public function safeUp()
    {
        $this->addColumn('{{%orders_items}}', 'discount_price', $this->integer()->after('price'));
    }

    public function safeDown()
    {
        $this->dropColumn('{{%orders_items}}', 'discount_price');
    }
}
