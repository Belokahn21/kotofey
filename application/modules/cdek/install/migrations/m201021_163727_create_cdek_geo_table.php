<?php

use yii\db\Migration;

class m201021_163727_create_cdek_geo_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('{{%cdek_geo}}', [
            'id' => $this->primaryKey(),
            'city_id' => $this->integer(),
            'FullName' => $this->string(),
            'CityName' => $this->string(),
            'FIAS' => $this->text(),
            'KLADR' => $this->text(),
            'pvzCode' => $this->string(),
        ]);
    }

    public function safeDown()
    {
        $this->dropTable('{{%cdek_geo}}');
    }
}
