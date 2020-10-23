<?php

use yii\db\Migration;

class m201023_044950_create_modify_media extends Migration
{
    public function safeUp()
    {
        $this->addColumn('{{%media}}', 'type', $this->string(10)->comment('image/file/video/music')->after('path'));
        $this->addColumn('{{%media}}', 'json_cdn_data', $this->text()->after('type'));
    }

    public function safeDown()
    {
        $this->dropColumn('{{%media}}', 'json_cdn_data');
    }
}
