<?php

use yii\db\Migration;

class m210713_103355_modify_tables extends Migration
{
    public function safeUp()
    {
        $this->renameTable('{{%product}}', '{{%offers}}');

        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%product}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(128),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ], $tableOptions);


        $this->addColumn('{{%offers}}', 'product_id', $this->integer()->after('id'));
    }

    public function safeDown()
    {
    }
}
