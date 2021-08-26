<?php

use yii\db\Migration;

class m210826_115038_modify_product_table extends Migration
{
    public function safeUp()
    {
        $this->addColumn('{{%product}}', 'ident_key', $this->string()->after('code'));
    }

    public function safeDown()
    {
    }
}
