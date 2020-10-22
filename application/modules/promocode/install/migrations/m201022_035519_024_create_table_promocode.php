<?php

use yii\db\Migration;

class m201022_035519_024_create_table_promocode extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%promocode}}', [
            'id' => $this->primaryKey(),
            'code' => $this->string(),
            'count' => $this->integer()->notNull()->defaultValue('0'),
            'discount' => $this->integer()->notNull()->defaultValue('0'),
            'infinity' => $this->tinyInteger(1)->notNull()->defaultValue('0'),
            'end_at' => $this->integer(),
            'start_at' => $this->integer(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ], $tableOptions);

        $this->createIndex('code', '{{%promocode}}', 'code', true);
    }

    public function down()
    {
        $this->dropTable('{{%promocode}}');
    }
}
