<?php

use yii\db\Migration;

class m190709_064914_create_table_support_category extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%support_category}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(),
            'html' => $this->text(),
            'description' => $this->text(),
            'sort' => $this->integer()->defaultValue('500'),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ], $tableOptions);

    }

    public function down()
    {
        $this->dropTable('{{%support_category}}');
    }
}
