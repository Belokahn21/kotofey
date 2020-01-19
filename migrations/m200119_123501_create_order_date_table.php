<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%order_date}}`.
 */
class m200119_123501_create_order_date_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%order_date}}', [
            'id' => $this->primaryKey(),
            'order_id' => $this->integer()->notNull(),
            'date' => $this->string(255)->notNull(),
            'time' => $this->string(255)->notNull(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%order_date}}');
    }
}
