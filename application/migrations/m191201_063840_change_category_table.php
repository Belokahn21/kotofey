<?php

use yii\db\Migration;

class m191201_063840_change_category_table extends Migration
{
	public function safeUp()
	{
		$this->renameTable('category', 'product_category');
		$this->addColumn('product_category', 'description', $this->text()->after('name'));
	}

	public function safeDown()
	{
	}
}
