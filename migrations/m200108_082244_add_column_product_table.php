<?php

use yii\db\Migration;

/**
 * Class m200108_082244_add_column_product_table
 */
class m200108_082244_add_column_product_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%product}}', 'is_weight', $this->boolean()->defaultValue(false));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200108_082244_add_column_product_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200108_082244_add_column_product_table cannot be reverted.\n";

        return false;
    }
    */
}
