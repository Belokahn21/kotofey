<?php

use yii\db\Migration;

class m200720_050039_create_modify_table extends Migration
{
	public function safeUp()
	{
		$this->addColumn('{{%payment}}', 'image', $this->string(255)->null()->after('name'));

	}

	public function safeDown()
	{
		$this->dropColumn('{{%payment}}', 'image');
	}
}
