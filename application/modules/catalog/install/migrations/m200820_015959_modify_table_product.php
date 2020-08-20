<?php

use yii\db\Migration;

class m200820_015959_modify_table_product extends Migration
{
	public function safeUp()
	{
		$this->addColumn('{{%product}}', 'threeDCode', $this->text()->null()->after('description'));
	}

	public function safeDown()
	{
		$this->dropColumn('{{%product}}', 'threeDCode');
	}
}
