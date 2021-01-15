<?php

use yii\db\Migration;

class m210115_061948_modify_animal_table extends Migration
{
    public function safeUp()
    {
        $this->addColumn('{{%animal}}', 'icon', $this->string()->after('name'));
    }

    public function safeDown()
    {
    }

}
