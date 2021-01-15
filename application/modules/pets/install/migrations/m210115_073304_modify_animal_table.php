<?php

use yii\db\Migration;

class m210115_073304_modify_animal_table extends Migration
{
    public function safeUp()
    {
        $this->addColumn('{{%animal}}', 'sort', $this->integer()->after('name')->defaultValue(500));
        $this->addColumn('{{%animal}}', 'is+', $this->boolean()->after('name')->defaultValue(500));
    }

    public function safeDown()
    {
    }
}
