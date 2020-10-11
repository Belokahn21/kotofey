<?php

use yii\db\Migration;

class m201011_031540_change_collation_order_table extends Migration
{
    public function safeUp()
    {
        $this->execute('ALTER TABLE `orders` ENGINE = InnoDB;');
        $this->execute('alter table `orders` convert to character set utf8 collate utf8_general_ci;');
    }

    public function safeDown()
    {
    }
}
