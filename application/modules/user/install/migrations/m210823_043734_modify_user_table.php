<?php

use yii\db\Migration;

class m210823_043734_modify_user_table extends Migration
{
    public function safeUp()
    {
        $this->addColumn('{{%user}}', 'login', $this->string()->after('id'));
    }

    public function safeDown()
    {
    }
}
