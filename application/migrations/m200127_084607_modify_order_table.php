<?php

use yii\db\Migration;

class m200127_084607_modify_order_table extends Migration
{
    public function safeUp()
    {
    	$this->execute('ALTER TABLE `orders` CHANGE `user_id` `user_id` INT(11) NULL');
    }

    public function safeDown()
    {
    }
}
