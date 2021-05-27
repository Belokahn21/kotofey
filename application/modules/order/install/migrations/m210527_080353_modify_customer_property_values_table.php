<?php

use yii\db\Migration;

class m210527_080353_modify_customer_property_values_table extends Migration
{
    public function safeUp()
    {
        $this->dropColumn('customer_properties_values', 'customer_id');
        $this->addColumn('customer_properties_values', 'customer_id', $this->bigInteger()->after('id')->notNull());
    }

    public function safeDown()
    {
    }
}
