<?php

use yii\db\Migration;

class m200116_051252_modify_product_table extends Migration
{
	public function safeUp()
	{
		$this->addColumn('{{%product}}', 'feed', $this->text()->null()->after('description'));
	}

	public function safeDown()
	{
		$this->dropColumn('{{%product}}','feed');
	}
}
