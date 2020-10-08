<?php

use yii\db\Migration;

/**
 * Class m191125_145016_create_modify_tables
 */
class m191125_145016_create_modify_tables extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropColumn('{{%orders}}', 'summared');
        $this->addColumn('{{%orders}}', 'is_bonus', $this->boolean()->defaultValue(false)->notNull()->after('type'));

        $this->renameColumn('{{%orders}}', 'user', 'user_id');
        $this->renameColumn('{{%orders}}', 'delivery', 'delivery_id');
        $this->renameColumn('{{%orders}}', 'payment', 'payment_id');
        $this->renameColumn('{{%orders}}', 'paid', 'is_paid');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%orders}}', 'is_bonus');
        $this->addColumn('{{%orders}}', 'summared', $this->integer()->defaultValue(0));

        $this->renameColumn('{{%orders}}', 'user_id', 'user');
        $this->renameColumn('{{%orders}}', 'delivery_id', 'delivery');
        $this->renameColumn('{{%orders}}', 'payment_id', 'payment');
        $this->renameColumn('{{%orders}}', 'is_paid', 'paid');
    }

}
