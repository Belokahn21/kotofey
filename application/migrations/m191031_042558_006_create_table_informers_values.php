<?php

use yii\db\Migration;

class m191031_042558_006_create_table_informers_values extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%informers_values}}', [
            'id' => $this->primaryKey(),
            'informer_id' => $this->integer()->notNull(),
            'description' => $this->text(),
            'value' => $this->string()->notNull(),
        ], $tableOptions);

    }

    public function down()
    {
        $this->dropTable('{{%informers_values}}');
    }
}
