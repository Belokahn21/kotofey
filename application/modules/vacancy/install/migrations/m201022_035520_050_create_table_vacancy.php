<?php

use yii\db\Migration;

class m201022_035520_050_create_table_vacancy extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%vacancy}}', [
            'id' => $this->primaryKey(),
            'sort' => $this->integer()->defaultValue('500'),
            'is_active' => $this->tinyInteger(1)->defaultValue('1'),
            'city_id' => $this->integer(),
            'title' => $this->string()->notNull(),
            'slug' => $this->string()->notNull(),
            'description' => $this->text(),
            'price' => $this->string(),
            'image' => $this->string(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ], $tableOptions);

    }

    public function down()
    {
        $this->dropTable('{{%vacancy}}');
    }
}
