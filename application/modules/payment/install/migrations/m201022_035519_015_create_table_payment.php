<?php

use yii\db\Migration;

class m201022_035519_015_create_table_payment extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%payment}}', [
            'id' => $this->primaryKey(),
            'active' => $this->tinyInteger(1)->notNull()->defaultValue('1'),
            'name' => $this->string(),
            'image' => $this->string(),
            'description' => $this->string(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ], $tableOptions);

    }

    public function down()
    {
        $this->dropTable('{{%payment}}');
    }
}
