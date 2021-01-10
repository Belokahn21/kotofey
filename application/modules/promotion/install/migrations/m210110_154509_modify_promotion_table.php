<?php

use yii\db\Migration;

class m210110_154509_modify_promotion_table extends Migration
{
    public function safeUp()
    {
        $this->execute('ALTER TABLE `promotion` CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;');

        $this->addColumn('{{%promotion}}', 'media_id', $this->integer()->after('is_active'));
        $this->addColumn('{{%promotion}}', 'image', $this->string()->after('media_id'));
    }

    public function safeDown()
    {
    }
}
