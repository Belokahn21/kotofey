<?php

use yii\db\Migration;

class m210422_070815_create_reviews_table extends Migration
{
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';

        $this->execute('DROP TABLE IF EXISTS `product_reviews`');

        $this->createTable('{{%reviews}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer(),
            'product_id' => $this->integer()->notNull(),
            'text' => $this->text()->notNull(),
            'image' => $this->string(),
            'rate' => $this->integer(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ], $tableOptions);
    }

    public function safeDown()
    {
        $this->dropTable('{{%reviews}}');
    }
}
