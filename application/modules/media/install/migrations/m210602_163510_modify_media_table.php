<?php

use yii\db\Migration;

class m210602_163510_modify_media_table extends Migration
{
    public function safeUp()
    {
        $this->execute('ALTER TABLE `media` CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;');
        $this->execute('ALTER TABLE `media_to_entity` CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;');
    }

    public function safeDown()
    {
    }
}
