<?php

use yii\db\Migration;

class m201230_100921_create_user_bonus_history_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('{{%user_bonus_history}}', [
            'id' => $this->primaryKey(),
            'bonus_account_id' => $this->integer()->notNull(),
            'count' => $this->integer(),
            'reason' => $this->text(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer()
        ]);
    }

    public function safeDown()
    {
        $this->dropTable('{{%user_bonus_history}}');
    }
}
