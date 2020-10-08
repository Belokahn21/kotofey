<?php

use yii\db\Migration;

/**
 * Class m200119_123923_table_changes
 */
class m200119_123923_table_changes extends Migration
{
    public function safeUp()
    {
        $this->dropTable('{{%order_date}}');

        $this->addColumn('{{%orders}}', 'date', $this->string(255)->notNull()->after('promo_code'));
        $this->addColumn('{{%orders}}', 'time', $this->string(255)->notNull()->after('date'));
    }

    public function safeDown()
    {
        echo "m200119_123923_table_changes cannot be reverted.\n";

        return false;
    }
}
