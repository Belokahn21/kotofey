<?php

use yii\db\Migration;

class m201102_165022_modify_engine_tables extends Migration
{
    public function safeUp()
    {
        $this->execute('ALTER TABLE `product_properties_values` ENGINE = InnoDB;');
        $this->execute('ALTER TABLE `informers_values` ENGINE = InnoDB;');
        $this->execute('ALTER TABLE `product_category` ENGINE = InnoDB;');
    }

    public function safeDown()
    {
    }
}
