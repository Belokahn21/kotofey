<?php

use yii\db\Migration;

class m210519_094059_modify_order_table extends Migration
{
    public function safeUp()
    {
        $this->addColumn('{{%order}}', 'manager_id', $this->integer());
    }

    public function safeDown()
    {
        $this->dropColumn('{{%order}}', 'manager_id');
    }
}
