<?php

use yii\db\Migration;

/**
 * Class m191217_151747_modify_vacancy_table
 */
class m191217_151747_modify_vacancy_table extends Migration
{
	/**
	 * {@inheritdoc}
	 */
	public function safeUp()
	{
		$this->renameTable('{{%vaccination}}', '{{%vacancy}}');
		$this->addColumn('{{%vacancy}}', 'slug', $this->string(255)->notNull()->after('title'));
	}

	/**
	 * {@inheritdoc}
	 */
	public function safeDown()
	{
		echo "m191217_151747_modify_vacancy_table cannot be reverted.\n";

		return false;
	}

	/*
	// Use up()/down() to run migration code without a transaction.
	public function up()
	{

	}

	public function down()
	{
		echo "m191217_151747_modify_vacancy_table cannot be reverted.\n";

		return false;
	}
	*/
}
