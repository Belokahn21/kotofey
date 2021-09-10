<?php

use yii\db\Migration;

class m210910_092049_rename_column_in_product_table extends Migration
{
    public function safeUp()
    {
        $this->renameColumn('{{%product}}', 'threeDCode', 'instruction');
    }

    public function safeDown()
    {
    }
}
