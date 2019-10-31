<?php

use yii\db\Migration;

class m191031_040229_008_create_table_orders extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%orders}}', [
            'id' => $this->primaryKey(),
            'type' => $this->integer()->notNull()->comment('быстрый/обычный'),
            'user' => $this->integer()->notNull(),
            'delivery' => $this->integer(),
            'payment' => $this->integer(),
            'paid' => $this->tinyInteger(1)->notNull(),
            'status' => $this->integer()->notNull(),
            'comment' => $this->text(),
            'promo_code' => $this->string(),
            'summared' => $this->integer()->notNull()->defaultValue('0')->comment('добавочная стоимость'),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ], $tableOptions);

    }

    public function down()
    {
        $this->dropTable('{{%orders}}');
    }
}
