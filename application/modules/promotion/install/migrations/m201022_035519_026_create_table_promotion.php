<?php

use yii\db\Migration;

class m201022_035519_026_create_table_promotion extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%promotion}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'is_active' => $this->tinyInteger(1)->defaultValue('1'),
            'start_at' => $this->integer(),
            'end_at' => $this->integer(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ], $tableOptions);

    }

    public function down()
    {
        $this->dropTable('{{%promotion}}');
    }
}
