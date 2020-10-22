<?php

use yii\db\Migration;

class m201022_035519_004_create_table_geo extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%geo}}', [
            'id' => $this->primaryKey(),
            'is_default' => $this->tinyInteger(1),
            'type' => $this->string(),
            'time_zone_id' => $this->integer(),
            'name' => $this->string()->notNull(),
            'address' => $this->string(),
            'start_at' => $this->integer(),
            'end_at' => $this->integer(),
            'slug' => $this->string()->notNull(),
            'sort' => $this->integer()->notNull()->defaultValue('500'),
            'active' => $this->tinyInteger(1)->notNull()->defaultValue('1'),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ], $tableOptions);

        $this->createIndex('is_default', '{{%geo}}', 'is_default', true);
    }

    public function down()
    {
        $this->dropTable('{{%geo}}');
    }
}
