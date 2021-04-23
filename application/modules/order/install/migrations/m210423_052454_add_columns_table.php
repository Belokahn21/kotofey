<?php

use yii\db\Migration;

class m210423_052454_add_columns_table extends Migration
{
    public function safeUp()
    {
        $this->addColumn('{{%order}}', 'client', $this->string()->after('email'));
    }

    public function safeDown()
    {
        $this->dropColumn('{{%order}}', 'client');
    }
}
