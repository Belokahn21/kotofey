<?php

use yii\db\Migration;

class m200720_045817_create_modify_table extends Migration
{
	public function safeUp()
	{
		$this->addColumn('{{%delivery}}', 'image', $this->string(255)->null()->after('name'));
	}

	public function safeDown()
	{
		$this->dropColumn('{{%delivery}}', 'image');
	}
}
