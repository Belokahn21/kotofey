<?php

use yii\db\Migration;

class m200608_090035_modify_order_items_table extends Migration
{
    public function safeUp()
    {
        $this->addColumn('{{orders_items}}', 'purchase', $this->integer()->after('count')->null());
    }

    public function safeDown()
    {
    }
}
