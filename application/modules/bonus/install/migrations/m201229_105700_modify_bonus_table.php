<?php

use yii\db\Migration;

class m201229_105700_modify_bonus_table extends Migration
{
    public function safeUp()
    {
        $this->dropForeignKey('fk-user_discount-user_id', '{{%discount}}');
        $this->renameTable('{{%discount}}', '{{%user_bonus}}');
        $this->dropColumn('{{%user_bonus}}', 'user_id');
        $this->addColumn('{{%user_bonus}}', 'phone', $this->bigInteger()->notNull()->after('id'));
    }

    public function safeDown()
    {
    }
}
