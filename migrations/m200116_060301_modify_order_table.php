<?php

use yii\db\Migration;

class m200116_060301_modify_order_table extends Migration
{
	public function safeUp()
	{
		$this->addColumn('{{%orders}}', 'notes', $this->text()->null()->after('comment'));
	}

	public function safeDown()
	{
		$this->dropColumn('{{%orders}}', 'notes');
	}
}
