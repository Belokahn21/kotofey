<?php

use yii\db\Migration;

class m201022_035519_005_create_table_geo_timezone extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%geo_timezone}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'value' => $this->string()->notNull(),
            'sort' => $this->integer()->defaultValue('500'),
            'is_active' => $this->tinyInteger(1)->defaultValue('1'),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ], $tableOptions);

    }

    public function down()
    {
        $this->dropTable('{{%geo_timezone}}');
    }
}
