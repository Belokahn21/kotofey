<?php

use yii\db\Migration;

class m210116_091543_modify_type_column_table extends Migration
{
    public function safeUp()
    {
        $this->dropColumn('{{%user_bonus_history}}', 'bonus_account_id');
        $this->addColumn('{{%user_bonus_history}}', 'bonus_account_id', $this->bigInteger()->after('id')->notNull());
    }

    public function safeDown()
    {
    }
}
