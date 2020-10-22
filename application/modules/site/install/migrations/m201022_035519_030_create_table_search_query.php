<?php

use yii\db\Migration;

class m201022_035519_030_create_table_search_query extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%search_query}}', [
            'id' => $this->primaryKey(),
            'text' => $this->text()->notNull(),
            'user_id' => $this->integer(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
            'count_find' => $this->integer(),
            'ip' => $this->string(),
        ], $tableOptions);

    }

    public function down()
    {
        $this->dropTable('{{%search_query}}');
    }
}
