<?php

use yii\db\Migration;

class m200223_144916_modify_order_table extends Migration
{
    public function safeUp()
    {
        $this->addColumn('{{%orders}}', 'is_close', $this->boolean()->after('is_paid'));
    }

    public function safeDown()
    {
        $this->dropColumn('{{%orders}}', 'is_close');
    }
}
