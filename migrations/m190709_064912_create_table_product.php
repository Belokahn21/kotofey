<?php

use yii\db\Migration;

class m190709_064912_create_table_product extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%product}}', [
            'id' => $this->primaryKey(),
            'article' => $this->string(),
            'name' => $this->string(),
            'description' => $this->text(),
            'seo_description' => $this->string(),
            'seo_keywords' => $this->string(),
            'image' => $this->string(),
            'images' => $this->string(),
            'slug' => $this->string(),
            'sort' => $this->integer()->defaultValue('500'),
            'category' => $this->integer()->defaultValue('0'),
            'price' => $this->integer(),
            'purchase' => $this->integer(),
            'count' => $this->integer(),
            'vitrine' => $this->tinyInteger()->defaultValue('0'),
            'stock_id' => $this->integer(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ], $tableOptions);

    }

    public function down()
    {
        $this->dropTable('{{%product}}');
    }
}
