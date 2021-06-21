<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%product_stock}}`.
 */
class m210621_111803_create_product_stock_table extends Migration
{
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%product_stock}}', [
            'id' => $this->primaryKey(),
            'product_id' => $this->integer()->notNull(),
            'stock_id' => $this->integer()->notNull(),
            'count' => $this->integer()->notNull()->defaultValue(0),
        ], $tableOptions);
    }

    public function safeDown()
    {
        $this->dropTable('{{%product_stock}}');
    }
}
