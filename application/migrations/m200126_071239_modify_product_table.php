<?php

use yii\db\Migration;

class m200126_071239_modify_product_table extends Migration
{

    public function safeUp()
    {
        $this->addColumn('{{%product}}', 'vendor_id', $this->integer()->null()->after('category_id'));
    }

    public function safeDown()
    {
    }
}
