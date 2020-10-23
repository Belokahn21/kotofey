<?php

use yii\db\Migration;

class m201022_165744_modify_product_table extends Migration
{
    public function safeUp()
    {
        $this->addColumn('{{%product}}', 'media_id', $this->integer()->null()->after('image'));
    }

    public function safeDown()
    {
        $this->dropColumn('{{%product}}', 'media_id');
    }
}
