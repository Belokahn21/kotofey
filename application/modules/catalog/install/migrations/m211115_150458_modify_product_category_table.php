<?php

use yii\db\Migration;

class m211115_150458_modify_product_category_table extends Migration
{
    public function safeUp()
    {
        $this->addColumn('{{%product_category}}', 'ozon_id', $this->integer()->after('id'));
    }

    public function safeDown()
    {
    }
}
