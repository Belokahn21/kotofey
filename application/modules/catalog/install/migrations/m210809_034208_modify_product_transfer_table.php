<?php

use yii\db\Migration;

/**
 * Class m210809_034208_modify_product_transfer_table
 */
class m210809_034208_modify_product_transfer_table extends Migration
{
    public function safeUp()
    {
        $this->addColumn('{{%product_transfer_history}}', 'operation_id', $this->integer()->notNull()->after('product_id'));
    }

    public function safeDown()
    {
    }
}
