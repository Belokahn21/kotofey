<?php

use yii\db\Migration;

class m201022_035519_038_create_table_stocks extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%stocks}}', [
            'id' => $this->primaryKey(),
            'active' => $this->tinyInteger(1)->notNull()->defaultValue('1'),
            'sort' => $this->integer()->notNull()->defaultValue('500'),
            'name' => $this->string()->notNull(),
            'address' => $this->string()->notNull(),
            'city_id' => $this->integer()->notNull()->defaultValue('0'),
            'time_start' => $this->integer()->notNull(),
            'time_end' => $this->integer()->notNull(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ], $tableOptions);

    }

    public function down()
    {
        $this->dropTable('{{%stocks}}');
    }
}
