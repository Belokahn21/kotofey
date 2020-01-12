<?php

use yii\db\Migration;

/**
 * Class m200108_082244_add_column_product_table
 */
class m200108_082244_modify_tables extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%product}}', 'is_weight', $this->boolean()->defaultValue(false));

        $this->addColumn('{{%orders_items}}', 'weight', $this->integer()->null());
        $this->addColumn('{{%orders_items}}', 'image', $this->string(255)->null());
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
