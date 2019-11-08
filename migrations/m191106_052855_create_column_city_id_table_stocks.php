<?php

use yii\db\Migration;

/**
 * Class m191106_052855_create_column_city_id_table_stocks
 */
class m191106_052855_create_column_city_id_table_stocks extends Migration
{
	/**
	 * {@inheritdoc}
	 */
	public function safeUp()
	{
		$this->addColumn('{{%stocks}}', 'city_id', $this->integer()->defaultValue(0)->notNull()->after('address'));
	}

	/**
	 * {@inheritdoc}
	 */
	public function safeDown()
	{
		$this->dropColumn('{{%stocks}}', 'city_id');
		return false;
	}

	/*
	// Use up()/down() to run migration code without a transaction.
	public function up()
	{

	}

	public function down()
	{
		echo "m191106_052855_create_column_city_id_table_stocks cannot be reverted.\n";

		return false;
	}
	*/
}
