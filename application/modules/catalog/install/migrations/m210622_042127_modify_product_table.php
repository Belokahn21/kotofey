<?php

use yii\db\Migration;

class m210622_042127_modify_product_table extends Migration
{
    public function safeUp()
    {
        $this->dropColumn('{{%product}}', 'stock_id');
    }

    public function safeDown()
    {
    }
}
