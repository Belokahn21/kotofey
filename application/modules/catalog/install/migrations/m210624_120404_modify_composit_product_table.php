<?php

use yii\db\Migration;

class m210624_120404_modify_composit_product_table extends Migration
{
    public function safeUp()
    {
        $this->addColumn('{{%composition_products}}', 'value', $this->string()->after('composition_type_id'));
    }

    public function safeDown()
    {
        $this->dropColumn('{{%composition_products}}', 'value');
    }

}
