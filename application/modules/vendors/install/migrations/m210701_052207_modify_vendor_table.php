<?php

use yii\db\Migration;

class m210701_052207_modify_vendor_table extends Migration
{
    public function safeUp()
    {
        $this->addColumn('{{%vendor}}', 'notes', $this->text()->after('type_price'));
    }

    public function safeDown()
    {
        $this->dropColumn('{{%vendor}}', 'notes');
    }
}
