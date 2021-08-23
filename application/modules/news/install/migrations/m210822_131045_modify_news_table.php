<?php

use yii\db\Migration;

class m210822_131045_modify_news_table extends Migration
{
    public function safeUp()
    {
        $this->addColumn('{{%news}}', 'author_id', $this->integer()->after('id'));
        $this->addColumn('{{%news}}', 'created_user_id', $this->integer()->after('id'));
        $this->addColumn('{{%news}}', 'preview_media_id', $this->integer()->after('id'));
        $this->addColumn('{{%news}}', 'detail_media_id', $this->integer()->after('id'));
    }

    public function safeDown()
    {
    }
}
