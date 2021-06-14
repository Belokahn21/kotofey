<?php

use yii\db\Migration;

class m210614_140237_modify_customer_table extends Migration
{
    public function safeUp()
    {
        $this->addColumn('{{%customer}}', 'description', $this->text()->after('name'));
    }

    public function safeDown()
    {
        $this->dropColumn('{{%customer}}', 'description');
    }
}
