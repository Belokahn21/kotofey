<?php

use yii\db\Migration;

class m191031_040229_004_create_table_discount extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%discount}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer(),
            'count' => $this->float(),
        ], $tableOptions);

    }

    public function down()
    {
        $this->dropTable('{{%discount}}');
    }
}
