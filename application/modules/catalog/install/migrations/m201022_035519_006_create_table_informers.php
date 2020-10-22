<?php

use yii\db\Migration;

class m201022_035519_006_create_table_informers extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%informers}}', [
            'id' => $this->primaryKey(),
            'sort' => $this->integer()->notNull()->defaultValue('500'),
            'is_active' => $this->tinyInteger(1)->defaultValue('1'),
            'is_show_filter' => $this->tinyInteger(1)->defaultValue('1'),
            'name' => $this->string()->notNull(),
            'slug' => $this->string()->notNull(),
            'description' => $this->text(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ], $tableOptions);

    }

    public function down()
    {
        $this->dropTable('{{%informers}}');
    }
}
