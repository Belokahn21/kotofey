<?php

use yii\db\Migration;

class m201022_035520_051_create_table_vendor extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%vendor}}', [
            'id' => $this->primaryKey(),
            'is_active' => $this->tinyInteger(1)->defaultValue('1'),
            'sort' => $this->integer()->defaultValue('500'),
            'name' => $this->string()->notNull(),
            'legal_name' => $this->string(),
            'discount' => $this->integer(),
            'min_summary_sale' => $this->integer(),
            'time_open' => $this->integer(),
            'time_close' => $this->integer(),
            'slug' => $this->string()->notNull(),
            'address' => $this->string(),
            'delivery_days' => $this->string(),
            'email' => $this->string(),
            'phone' => $this->string(),
            'group_id' => $this->integer(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
            'how_send_order' => $this->integer()->notNull()->defaultValue('0'),
        ], $tableOptions);

    }

    public function down()
    {
        $this->dropTable('{{%vendor}}');
    }
}
