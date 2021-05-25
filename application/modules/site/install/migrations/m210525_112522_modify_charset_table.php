<?php

use yii\db\Migration;

class m210525_112522_modify_charset_table extends Migration
{
    public function safeUp()
    {
        $this->execute('alter table module_settings convert to CHARACTER SET utf8 COLLATE utf8_unicode_ci;');
    }

    public function safeDown()
    {
    }
}
