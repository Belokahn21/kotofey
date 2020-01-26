<?php

use yii\db\Migration;

/**
 * Class m200126_152119_modify_vendor_table
 */
class m200126_152119_modify_vendor_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%vendor}}', 'legal_name', $this->string()->after('name'));
        $this->addColumn('{{%vendor}}', 'discount', $this->integer()->after('legal_name'));
        $this->addColumn('{{%vendor}}', 'time_open', $this->integer()->after('discount'));
        $this->addColumn('{{%vendor}}', 'time_close', $this->integer()->after('time_open'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200126_152119_modify_vendor_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200126_152119_modify_vendor_table cannot be reverted.\n";

        return false;
    }
    */
}
