<?php

use yii\db\Migration;

/**
 * Class m200102_082705_modify_product_table
 */
class m200102_082705_modify_product_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->renameColumn('{{%product}}', 'category', 'category_id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200102_082705_modify_product_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200102_082705_modify_product_table cannot be reverted.\n";

        return false;
    }
    */
}
