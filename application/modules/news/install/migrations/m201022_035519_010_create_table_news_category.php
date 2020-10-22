<?php

use yii\db\Migration;

class m201022_035519_010_create_table_news_category extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%news_category}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'sort' => $this->integer()->notNull(),
            'parent' => $this->integer()->notNull(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ], $tableOptions);

    }

    public function down()
    {
        $this->dropTable('{{%news_category}}');
    }
}
