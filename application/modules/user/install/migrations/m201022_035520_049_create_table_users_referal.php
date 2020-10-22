<?php

use yii\db\Migration;

class m201022_035520_049_create_table_users_referal extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%users_referal}}', [
            'id' => $this->primaryKey(),
            'is_active' => $this->tinyInteger(1)->defaultValue('1'),
            'user_id' => $this->integer()->notNull(),
            'key' => $this->string(200)->notNull(),
            'key_called' => $this->string(200),
            'has_rewarded' => $this->tinyInteger(1)->defaultValue('0'),
            'count_reward' => $this->integer()->defaultValue('0'),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ], $tableOptions);

        $this->createIndex('key', '{{%users_referal}}', 'key', true);
    }

    public function down()
    {
        $this->dropTable('{{%users_referal}}');
    }
}
