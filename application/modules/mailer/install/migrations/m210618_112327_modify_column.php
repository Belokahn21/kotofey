<?php

use yii\db\Migration;

class m210618_112327_modify_column extends Migration
{
    public function safeUp()
    {
        $this->execute('ALTER TABLE `mail_templates` MODIFY `text` LARGETEXT;');
    }

    public function safeDown()
    {
    }
}
