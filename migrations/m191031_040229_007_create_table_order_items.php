<?php

use yii\db\Migration;

class m191031_040229_007_create_table_order_items extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%order_items}}', [
            'id' => $this->primaryKey(),
            'orderId' => $this->integer(),
            'productId' => $this->integer(),
            'count' => $this->integer(),
            'summ' => $this->integer(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ], $tableOptions);

    }

    public function down()
    {
        $this->dropTable('{{%order_items}}');
    }
}
