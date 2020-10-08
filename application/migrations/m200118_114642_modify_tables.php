<?php

use yii\db\Migration;

class m200118_114642_modify_tables extends Migration
{
    public function safeUp()
    {
        $this->execute('ALTER TABLE `geo` CHANGE `time_zone_id` `time_zone_id` INT NULL DEFAULT NULL;');
        $this->execute('ALTER TABLE `geo` CHANGE `time_zone_id` `time_zone_id` INT(11) NULL DEFAULT NULL;');
    }

    public function safeDown()
    {
    }
}
