<?php

use yii\db\Migration;

/**
 * Class m191106_084837_change_geo
 */
class m191106_084837_change_geo extends Migration
{
	/**
	 * {@inheritdoc}
	 */
	public function safeUp()
	{
		$this->dropTable('{{%geo_type}}');
		$this->dropColumn('{{%geo}}', 'type_id');
		$this->addColumn('{{%geo}}', 'type', $this->string()->after('id'));
	}

	/**
	 * {@inheritdoc}
	 */
	public function safeDown()
	{
		return false;
	}

	/*
	// Use up()/down() to run migration code without a transaction.
	public function up()
	{

	}

	public function down()
	{
		echo "m191106_084837_change_geo cannot be reverted.\n";

		return false;
	}
	*/
}
