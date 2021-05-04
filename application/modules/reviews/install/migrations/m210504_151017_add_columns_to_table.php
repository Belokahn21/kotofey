<?php

use yii\db\Migration;

class m210504_151017_add_columns_to_table extends Migration
{
    public function safeUp()
    {
        $this->addColumn('{{%reviews}}', 'pluses', $this->text()->after('text'));
        $this->addColumn('{{%reviews}}', 'minuses', $this->text()->after('text'));
    }

    public function safeDown()
    {
        $this->dropColumn('{{%reviews}}', 'pluses');
        $this->dropColumn('{{%reviews}}', 'minuses');
    }
}
