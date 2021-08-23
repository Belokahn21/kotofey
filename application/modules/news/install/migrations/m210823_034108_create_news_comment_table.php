<?php

use yii\db\Migration;

class m210823_034108_create_news_comment_table extends Migration
{
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }
        $this->createTable('{{%news_comment}}', [
            'id' => $this->primaryKey(),
            'is_active' => $this->boolean()->defaultValue(0),
            'parent_id' => $this->integer(),
            'author_id' => $this->integer(),
            'text' => $this->text()->notNull(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ], $tableOptions);


        $this->renameColumn('{{%news}}', 'category', 'category_id');
    }

    public function safeDown()
    {
        $this->dropTable('{{%news_comment}}');
    }
}
