<?php

use yii\db\Migration;

class m210527_043430_modify_customer_properties_tables extends Migration
{
    public function safeUp()
    {
        $this->addColumn('{{%customer_properties}}', 'cross', $this->string()->null()->after('name'));
    }

    public function safeDown()
    {
        $this->dropColumn('{{%customer_properties}}', 'cross');
    }
}
