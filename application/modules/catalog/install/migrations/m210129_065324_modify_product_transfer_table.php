<?php

use yii\db\Migration;

class m210129_065324_modify_product_transfer_table extends Migration
{
    public function safeUp()
    {
        $this->addColumn('{{%product_transfer_history}}', 'user_id', $this->integer()->notNull()->after('product_id'));
    }

    public function safeDown()
    {
    }
}
