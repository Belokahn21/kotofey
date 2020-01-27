<?php

use yii\db\Migration;

/**
 * Class m200127_030056_modify_vendor_table
 */
class m200127_030056_modify_vendor_table extends Migration
{
	/**
	 * {@inheritdoc}
	 */
	public function safeUp()
	{
		$this->addColumn('{{%vendor}}', 'min_summary_sale', $this->integer()->after('discount'));
	}

	/**
	 * {@inheritdoc}
	 */
	public function safeDown()
	{
		echo "m200127_030056_modify_vendor_table cannot be reverted.\n";

		return false;
	}

	/*
	// Use up()/down() to run migration code without a transaction.
	public function up()
	{

	}

	public function down()
	{
		echo "m200127_030056_modify_vendor_table cannot be reverted.\n";

		return false;
	}
	*/
}
