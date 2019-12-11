<?php

use yii\db\Migration;

/**
 * Class m191211_071611_modify_short_links_table
 */
class m191211_071611_modify_short_links_table extends Migration
{
	/**
	 * {@inheritdoc}
	 */
	public function safeUp()
	{
		$this->addColumn('{{%short_links}}', 'name', $this->string(255)->after('id'));
	}

	/**
	 * {@inheritdoc}
	 */
	public function safeDown()
	{
		$this->dropColumn('{{%short_links}}', 'name');
	}

	/*
	// Use up()/down() to run migration code without a transaction.
	public function up()
	{

	}

	public function down()
	{
		echo "m191211_071611_modify_short_links_table cannot be reverted.\n";

		return false;
	}
	*/
}
