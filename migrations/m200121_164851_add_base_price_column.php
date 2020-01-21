<?php

use yii\db\Migration;

class m200121_164851_add_base_price_column extends Migration
{
    public function safeUp()
    {
        $this->addColumn('{{%product}}', 'base_price', $this->integer());
    }

    public function safeDown()
    {
        $this->dropColumn('{{%product}}', 'base_price');
    }
}
