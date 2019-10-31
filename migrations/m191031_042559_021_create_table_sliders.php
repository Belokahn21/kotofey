<?php

use yii\db\Migration;

class m191031_042559_021_create_table_sliders extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%sliders}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'active' => $this->tinyInteger(1)->notNull()->defaultValue('1'),
            'sort' => $this->integer()->notNull()->defaultValue('500'),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ], $tableOptions);

    }

    public function down()
    {
        $this->dropTable('{{%sliders}}');
    }
}
