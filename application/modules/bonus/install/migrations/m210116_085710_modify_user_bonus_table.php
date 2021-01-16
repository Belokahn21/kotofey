<?php

use yii\db\Migration;

class m210116_085710_modify_user_bonus_table extends Migration
{
    public function safeUp()
    {
        $this->addColumn('{{%user_bonus}}', 'created_at', $this->integer());
        $this->addColumn('{{%user_bonus}}', 'updated_at', $this->integer());
    }

    public function safeDown()
    {
    }
}
