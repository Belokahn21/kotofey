<?php

use yii\db\Migration;

class m210720_095238_modify_promocode_table extends Migration
{
    public function safeUp()
    {
        $this->addColumn('{{%promocode}}', 'quality', $this->string()->after('id'));
    }

    public function safeDown()
    {
    }
}
