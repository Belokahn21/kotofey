<?php

use yii\db\Migration;

class m191031_042559_015_create_table_product_reviews extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%product_reviews}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer(),
            'product' => $this->integer()->notNull(),
            'text' => $this->text(),
            'images' => $this->text(),
            'paid' => $this->tinyInteger(1)->notNull(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ], $tableOptions);

    }

    public function down()
    {
        $this->dropTable('{{%product_reviews}}');
    }
}
