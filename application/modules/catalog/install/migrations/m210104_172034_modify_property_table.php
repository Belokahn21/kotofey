<?php

use yii\db\Migration;

class m210104_172034_modify_property_table extends Migration
{
    public function safeUp()
    {
        $this->addColumn('{{%properties}}', 'group_id', $this->integer()->null()->after('id'));
    }

    public function safeDown()
    {
    }
}
