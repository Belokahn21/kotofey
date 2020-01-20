<?php

use yii\db\Migration;

class m200120_054853_change_table_category_to_seo extends Migration
{
	public function safeUp()
	{
		$this->addColumn('{{%product_category}}', 'seo_title', $this->string(255)->null()->after('name'));
	}

	public function safeDown()
	{
		$this->dropColumn('{{%product_category}}', 'seo_title');
	}
}
