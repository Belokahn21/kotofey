<?php

use yii\db\Migration;

/**
 * Class m200817_174251_modify_order_table
 */
class m200817_174251_modify_order_table extends Migration
{
    public function safeUp()
    {
        $this->addColumn('{{%orders}}', 'promocode', $this->string(255)->after('id'));
    }

    public function safeDown()
    {
        $this->dropColumn('{{%orders}}', 'promocode');
    }
}
