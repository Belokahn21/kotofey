<?php

use yii\db\Migration;

class m211203_015539_modify_order_table extends Migration
{
    public function safeUp()
    {
        $this->dropColumn('{{%order}}', 'type');
        $this->addColumn('{{%order}}', 'billing_id', $this->integer());
    }

    public function safeDown()
    {
    }

}
