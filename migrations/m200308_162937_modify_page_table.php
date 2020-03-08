<?php

use yii\db\Migration;

class m200308_162937_modify_page_table extends Migration
{
    public function safeUp()
    {
        $this->addColumn('{{%pages}}', 'is_active', $this->boolean()->defaultValue(1)->after('id'));
        $this->renameTable('pages', 'news');
        $this->renameTable('pages_category', 'news_category');
    }

    public function safeDown()
    {
        $this->dropColumn('{{%pages}}', 'is_active');
    }
}
