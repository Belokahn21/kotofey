<?php

use yii\db\Migration;

class m191031_042559_009_create_table_pages extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%pages}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string()->notNull(),
            'slug' => $this->string()->notNull(),
            'sort' => $this->integer()->notNull(),
            'category' => $this->integer(),
            'preview' => $this->text()->notNull(),
            'preview_image' => $this->string(),
            'detail' => $this->text()->notNull(),
            'detail_image' => $this->string(),
            'seo_keywords' => $this->string(),
            'seo_description' => $this->string(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ], $tableOptions);

    }

    public function down()
    {
        $this->dropTable('{{%pages}}');
    }
}
