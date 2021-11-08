<?php

use yii\db\Migration;

class m211107_073246_create_marketplace_product_status_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('{{%marketplace_product_status}}', [
            'id' => $this->primaryKey(),
            'product_id' => $this->integer()->notNull(),
            'task_id' => $this->integer()->notNull(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ]);

        $this->createIndex('idx-marketplace_product_status-marketplace-product_id', '{{%marketplace_product_status}}', 'product_id');
        $this->addForeignKey('fk-marketplace_product_status-marketplace-product_id', '{{%marketplace_product_status}}', 'product_id', '{{%product}}', 'id', 'CASCADE', 'CASCADE');
    }

    public function safeDown()
    {
        $this->dropTable('{{%marketplace_product_status}}');
    }
}
