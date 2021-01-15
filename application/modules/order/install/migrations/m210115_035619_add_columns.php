<?php

use yii\db\Migration;

class m210115_035619_add_columns extends Migration
{
    public function safeUp()
    {
        $this->addColumn('{{%order}}', 'floor_house', $this->integer()->after('number_home'));
        $this->addColumn('{{%order}}', 'entrance', $this->integer()->after('number_home'));
    }

    public function safeDown()
    {
    }
}
