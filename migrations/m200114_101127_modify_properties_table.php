<?php

use yii\db\Migration;

/**
 * Class m200114_101127_modify_properties_table
 */
class m200114_101127_modify_properties_table extends Migration
{
	/**
	 * {@inheritdoc}
	 */
	public function safeUp()
	{
		$this->addColumn('{{%product_properties}}', 'multiple', $this->boolean()->defaultValue(false)->after('active'));
	}

	/**
	 * {@inheritdoc}
	 */
	public function safeDown()
	{
		echo "m200114_101127_modify_properties_table cannot be reverted.\n";

		return false;
	}

	/*
	// Use up()/down() to run migration code without a transaction.
	public function up()
	{

	}

	public function down()
	{
		echo "m200114_101127_modify_properties_table cannot be reverted.\n";

		return false;
	}
	*/
}
