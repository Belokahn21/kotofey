<?php

use yii\db\Migration;

class m201023_110130_modify_slider_image_table extends Migration
{
    public function safeUp()
    {
        $this->addColumn('{{%sliders_images}}', 'media_id', $this->integer()->after('image'));
    }

    public function safeDown()
    {
        $this->dropColumn('{{%sliders_images}}', 'media_id');
    }
}
