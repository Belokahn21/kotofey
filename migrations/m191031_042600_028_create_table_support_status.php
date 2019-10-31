<?php

use yii\db\Migration;

class m191031_042600_028_create_table_support_status extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%support_status}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(),
            'sort' => $this->integer()->defaultValue('500'),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ], $tableOptions);

    }

    public function down()
    {
        $this->dropTable('{{%support_status}}');
    }
}
