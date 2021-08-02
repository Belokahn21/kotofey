<?php

use yii\db\Migration;

class m210802_110234_modify_order_table extends Migration
{
    public function safeUp()
    {
        $this->addColumn('{{%order}}', 'is_skip', $this->integer()->after('id'));
    }

    public function safeDown()
    {
    }
}
