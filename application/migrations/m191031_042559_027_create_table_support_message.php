<?php

use yii\db\Migration;

class m191031_042559_027_create_table_support_message extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%support_message}}', [
            'id' => $this->primaryKey(),
            'ticket_id' => $this->integer(),
            'user_id' => $this->integer(),
            'text' => $this->text(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ], $tableOptions);

    }

    public function down()
    {
        $this->dropTable('{{%support_message}}');
    }
}
