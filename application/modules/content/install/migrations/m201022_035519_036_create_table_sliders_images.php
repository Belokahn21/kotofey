<?php

use yii\db\Migration;

class m201022_035519_036_create_table_sliders_images extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%sliders_images}}', [
            'id' => $this->primaryKey(),
            'active' => $this->tinyInteger(1)->notNull()->defaultValue('1'),
            'sort' => $this->integer()->notNull()->defaultValue('500'),
            'slider_id' => $this->integer()->notNull(),
            'image' => $this->string()->notNull(),
            'text' => $this->string()->notNull(),
            'description' => $this->text()->notNull(),
            'link' => $this->text(),
            'start_at' => $this->integer(),
            'end_at' => $this->integer(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ], $tableOptions);

    }

    public function down()
    {
        $this->dropTable('{{%sliders_images}}');
    }
}
