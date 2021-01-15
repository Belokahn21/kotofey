<?php

use yii\db\Migration;

class m210115_073304_modify_animal_table extends Migration
{
    public function safeUp()
    {
        $this->addColumn('{{%animal}}', 'sort', $this->integer()->after('name')->defaultValue(500));
        $this->addColumn('{{%animal}}', 'is_active', $this->boolean()->after('sort')->defaultValue(1));
    }

    public function safeDown()
    {
    }
}
