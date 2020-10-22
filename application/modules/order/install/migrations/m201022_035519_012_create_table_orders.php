<?php

use yii\db\Migration;

class m201022_035519_012_create_table_orders extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%orders}}', [
            'id' => $this->primaryKey(),
            'promocode' => $this->string(),
            'phone' => $this->bigInteger(),
            'email' => $this->string(),
            'type' => $this->integer()->notNull(),
            'user_id' => $this->integer(),
            'delivery_id' => $this->integer(),
            'payment_id' => $this->integer(),
            'is_paid' => $this->tinyInteger(1)->notNull(),
            'is_close' => $this->tinyInteger(1),
            'is_cancel' => $this->tinyInteger(1)->defaultValue('0'),
            'status' => $this->integer()->notNull(),
            'comment' => $this->text(),
            'ip' => $this->string()->notNull(),
            'notes' => $this->text(),
            'promo_code' => $this->string(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
            'postalcode' => $this->string(15),
            'country' => $this->string(100),
            'region' => $this->string(100),
            'city' => $this->string(100),
            'street' => $this->string(100),
            'number_home' => $this->string(10),
            'number_appartament' => $this->string(10),
        ], $tableOptions);

    }

    public function down()
    {
        $this->dropTable('{{%orders}}');
    }
}
