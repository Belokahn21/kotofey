<?php

use yii\db\Migration;

class m201022_111425_modify_product_table extends Migration
{
    public function safeUp()
    {
        $this->addColumn('{{%product}}', 'is_ali', $this->integer(1)->notNull()->defaultValue(0)->after('status_id'));
    }

    public function safeDown()
    {
    }
}
