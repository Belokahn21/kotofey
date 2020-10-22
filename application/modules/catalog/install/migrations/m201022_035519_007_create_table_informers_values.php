<?php

use yii\db\Migration;

class m201022_035519_007_create_table_informers_values extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%informers_values}}', [
            'id' => $this->primaryKey(),
            'active' => $this->tinyInteger(1)->notNull()->defaultValue('1'),
            'sort' => $this->integer()->notNull()->defaultValue('500'),
            'image' => $this->string(),
            'slug' => $this->string(),
            'informer_id' => $this->integer()->notNull(),
            'description' => $this->text(),
            'name' => $this->string()->notNull(),
            'link' => $this->text(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ], $tableOptions);

    }

    public function down()
    {
        $this->dropTable('{{%informers_values}}');
    }
}
