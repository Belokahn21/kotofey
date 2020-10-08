<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%order_billing}}`.
 */
class m191228_183134_create_order_billing_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%order_billing}}', [
            'id' => $this->primaryKey(),
            'order_id' => $this->integer(),
            'user_billing_id' => $this->integer(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%order_billing}}');
    }
}
