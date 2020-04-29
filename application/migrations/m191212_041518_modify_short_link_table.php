<?php

use yii\db\Migration;

/**
 * Class m191212_041518_modify_short_link_table
 */
class m191212_041518_modify_short_link_table extends Migration
{
	/**
	 * {@inheritdoc}
	 */
	public function safeUp()
	{
		$this->addColumn('{{%short_links}}', 'visits', $this->integer()->defaultValue(0)->after('name'));
	}

	/**
	 * {@inheritdoc}
	 */
	public function safeDown()
	{
		$this->dropColumn('{{%short_links}}', 'visits');
	}

	/*
	// Use up()/down() to run migration code without a transaction.
	public function up()
	{

	}

	public function down()
	{
		echo "m191212_041518_modify_short_link_table cannot be reverted.\n";

		return false;
	}
	*/
}
