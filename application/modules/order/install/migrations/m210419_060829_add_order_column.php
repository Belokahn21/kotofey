<?php

use yii\db\Migration;

class m210419_060829_add_order_column extends Migration
{
    public function safeUp()
    {
        $this->addColumn('{{%order}}', 'odd', $this->integer()->after('id')->comment('Сдача'));
    }

    public function safeDown()
    {
    }
}
