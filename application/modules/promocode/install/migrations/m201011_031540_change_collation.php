<?php

use yii\db\Migration;

class m201011_031540_change_collation extends Migration
{
    public function safeUp()
    {
        $this->execute('ALTER TABLE `promocode` ENGINE = InnoDB;');
        $this->execute('alter table `promocode` convert to character set utf8 collate utf8_general_ci;');

        $this->execute('ALTER TABLE `promocode_user` ENGINE = InnoDB;');
        $this->execute('alter table `promocode_user` convert to character set utf8 collate utf8_general_ci;');
    }

    public function safeDown()
    {
    }
}
