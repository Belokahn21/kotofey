<?php

use yii\db\Migration;

class m210627_051535_modify_vendor_table extends Migration
{
    public function safeUp()
    {
        $this->addColumn('{{%vendor}}', 'type_price', $this->string()->after('name'));
    }

    public function safeDown()
    {
        $this->dropColumn('{{%vendor}}', 'type_price');
    }
}
