<?php

use yii\db\Migration;

class m210107_100147_modify_promo_prod_mech_table extends Migration
{
    public function safeUp()
    {
        $this->addColumn('{{%promotion_product_mechanics}}', 'discountRule', $this->string()->after('product_id'));
        $this->addColumn('{{%promotion_product_mechanics}}', 'amount', $this->integer()->after('product_id'));
    }

    public function safeDown()
    {
    }
}
