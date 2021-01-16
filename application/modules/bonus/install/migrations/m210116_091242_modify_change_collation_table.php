<?php

use yii\db\Migration;

class m210116_091242_modify_change_collation_table extends Migration
{
    public function safeUp()
    {
        $this->execute('alter table `user_bonus` convert to character set utf8 collate utf8_general_ci;');
        $this->execute('alter table `user_bonus_history` convert to character set utf8 collate utf8_general_ci;');
    }

    public function safeDown()
    {
    }
}
