<?php

use yii\db\Migration;

class m201022_035519_008_create_table_logger extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%logger}}', [
            'id' => $this->primaryKey(),
            'message' => $this->text()->notNull(),
            'status' => $this->integer()->notNull()->defaultValue('200'),
            'uniqCode' => $this->string()->notNull(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ], $tableOptions);

    }

    public function down()
    {
        $this->dropTable('{{%logger}}');
    }
}
