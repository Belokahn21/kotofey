<?php

use yii\db\Migration;

class m210701_075702_modify_promo_history_table extends Migration
{
    public function safeUp()
    {
        $this->dropColumn('{{%promotion_mail_history}}', 'user_id');
        $this->addColumn('{{%promotion_mail_history}}', 'email', $this->string()->after('promotion_id')->unique());
    }

    public function safeDown()
    {
    }
}
