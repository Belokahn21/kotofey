<?php

use yii\db\Migration;

class m200826_031540_modify_promo_table extends Migration
{
    public function safeUp()
    {
        $this->addColumn('{{%promocode}}', 'start_at', $this->integer()->null()->defaultValue(null)->after('infinity'));
        $this->addColumn('{{%promocode}}', 'end_at', $this->integer()->null()->defaultValue(null)->after('infinity'));
    }

    public function safeDown()
    {
        $this->dropColumn('{{%promocode}}', 'start_at');
        $this->dropColumn('{{%promocode}}', 'end_at');
    }
}
