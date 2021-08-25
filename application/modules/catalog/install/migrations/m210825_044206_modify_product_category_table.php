<?php

use yii\db\Migration;

class m210825_044206_modify_product_category_table extends Migration
{
    public function safeUp()
    {
        $this->renameColumn('{{%product_category}}', 'parent', 'parent_category_id');
    }

    public function safeDown()
    {
    }
}
