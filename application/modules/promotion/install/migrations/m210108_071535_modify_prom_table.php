<?php

use yii\db\Migration;

class m210108_071535_modify_prom_table extends Migration
{
    public function safeUp()
    {
        $this->addColumn('{{%promotion_product_mechanics}}', 'promotion_id', $this->integer()->after('product_id'));
    }

    public function safeDown()
    {
    }

}
