<?php

use yii\db\Migration;

class m201022_035519_031_create_table_short_links extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%short_links}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(),
            'visits' => $this->integer()->defaultValue('0'),
            'is_active' => $this->tinyInteger(1)->defaultValue('1'),
            'sort' => $this->integer()->defaultValue('500'),
            'link' => $this->text()->notNull(),
            'short_code' => $this->string(150)->notNull(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ], $tableOptions);

        $this->createIndex('short_code', '{{%short_links}}', 'short_code', true);
    }

    public function down()
    {
        $this->dropTable('{{%short_links}}');
    }
}
