<?php

use yii\db\Migration;

class m210817_155150_modify_price_table extends Migration
{
    public function safeUp()
    {
        $this->addColumn('{{%price}}', 'code', $this->string()->after('id')->notNull());
    }

    public function safeDown()
    {

    }
}
