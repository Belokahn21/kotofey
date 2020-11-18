<?php

use yii\db\Migration;

class m201118_081930_add_column_discount_to_order_table extends Migration
{
    public function safeUp()
    {
        $this->addColumn('{{%orders}}', 'discount', $this->string('15')->after('id'));
    }

    public function safeDown()
    {
        $this->dropColumn('{{%orders}}', 'discount');
    }
}
