<?php

use yii\db\Migration;

class m201022_035519_017_create_table_product_category extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%product_category}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(128),
            'seo_title' => $this->string(),
            'description' => $this->text(),
            'seo_keywords' => $this->string(),
            'seo_description' => $this->string(),
            'slug' => $this->string(),
            'sort' => $this->integer(),
            'parent' => $this->integer(),
            'image' => $this->string(256),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ], $tableOptions);

    }

    public function down()
    {
        $this->dropTable('{{%product_category}}');
    }
}
