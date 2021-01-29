<?php

use yii\db\Migration;

class m210129_034501_modify_transfer_product_table extends Migration
{
    public function safeUp()
    {
        $this->addColumn('{{%product_transfer_history}}', 'count', $this->integer()->notNull()->defaultValue(0)->after('product_id'));
    }

    public function safeDown()
    {
    }
}
