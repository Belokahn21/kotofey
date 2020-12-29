<?php

use yii\db\Migration;

class m201229_105700_modify_bonus_table extends Migration
{
    public function safeUp()
    {
        $this->renameTable('{{%discount}}', '{{%user_bonus}}');

        $this->execute('ALTER TABLE user_bonus DROP FOREIGN KEY fk-user_discount-user_id');

        $this->renameColumn('{{%user_bonus}}', 'user_id', 'phone');
    }

    public function safeDown()
    {
    }
}
