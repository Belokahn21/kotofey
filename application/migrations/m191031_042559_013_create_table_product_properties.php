<?php

use yii\db\Migration;

class m191031_042559_013_create_table_product_properties extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%product_properties}}', [
            'id' => $this->primaryKey(),
            'active' => $this->tinyInteger(1)->notNull()->defaultValue('1'),
            'need_show' => $this->tinyInteger(1)->notNull()->defaultValue('1'),
            'sort' => $this->integer()->defaultValue('500'),
            'name' => $this->string()->notNull(),
            'slug' => $this->string()->notNull(),
            'type' => $this->integer(),
            'informer_id' => $this->integer(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ], $tableOptions);

    }

    public function down()
    {
        $this->dropTable('{{%product_properties}}');
    }
}
