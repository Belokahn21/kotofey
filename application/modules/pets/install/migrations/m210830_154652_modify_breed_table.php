<?php

use yii\db\Migration;

class m210830_154652_modify_breed_table extends Migration
{
    public function safeUp()
    {
        $this->addColumn('{{%breed}}', 'size', $this->string()->after('id'));
    }

    public function safeDown()
    {
    }
}
