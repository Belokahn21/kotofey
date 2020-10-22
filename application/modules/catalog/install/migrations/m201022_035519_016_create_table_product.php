<?php

use yii\db\Migration;

class m201022_035519_016_create_table_product extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%product}}', [
            'id' => $this->primaryKey(),
            'article' => $this->string(64),
            'name' => $this->string(),
            'description' => $this->text(),
            'threeDCode' => $this->text(),
            'feed' => $this->text(),
            'seo_description' => $this->string(150),
            'seo_keywords' => $this->string(180),
            'image' => $this->string(),
            'images' => $this->text(),
            'slug' => $this->string(),
            'sort' => $this->integer()->defaultValue('500'),
            'category_id' => $this->integer()->defaultValue('0'),
            'vendor_id' => $this->integer(),
            'price' => $this->integer(),
            'discount_price' => $this->integer(),
            'purchase' => $this->integer(),
            'count' => $this->integer(),
            'vitrine' => $this->tinyInteger(1)->defaultValue('0'),
            'stock_id' => $this->integer(),
            'code' => $this->text(),
            'barcode' => $this->string()->comment('Штрих-код'),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
            'is_weight' => $this->tinyInteger(1)->defaultValue('0'),
            'base_price' => $this->integer(),
            'status_id' => $this->integer()->defaultValue('1'),
        ], $tableOptions);

    }

    public function down()
    {
        $this->dropTable('{{%product}}');
    }
}
