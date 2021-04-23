<?php

use yii\db\Migration;

/**
 * Class m210423_052430_add_columns_table
 */
class m210423_052430_add_columns_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m210423_052430_add_columns_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210423_052430_add_columns_table cannot be reverted.\n";

        return false;
    }
    */
}
