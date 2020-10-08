<?php

use yii\db\Migration;

/**
 * Class m200107_172417_modify_pages_table
 */
class m200107_172417_modify_pages_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute("ALTER TABLE `pages` CHANGE `sort` `sort` INT(11) NOT NULL DEFAULT '500'");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200107_172417_modify_pages_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200107_172417_modify_pages_table cannot be reverted.\n";

        return false;
    }
    */
}
