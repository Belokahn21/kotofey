<?php

use yii\db\Migration;

class m201022_035519_009_create_table_news extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%news}}', [
            'id' => $this->primaryKey(),
            'is_active' => $this->tinyInteger(1)->defaultValue('1'),
            'title' => $this->string()->notNull(),
            'slug' => $this->string()->notNull(),
            'sort' => $this->integer()->notNull()->defaultValue('500'),
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
        $this->dropTable('{{%news}}');
    }
}
