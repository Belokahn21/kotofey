<?php

use yii\db\Migration;

class m210515_113410_modify_admission_table extends Migration
{
    public function safeUp()
    {
        $this->addColumn('{{%notify_admission}}', 'phone', $this->bigInteger()->after('email'));
    }

    public function safeDown()
    {
        $this->dropColumn('{{%notify_admission}}', 'phone');
    }
}
