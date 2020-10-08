<?php

use yii\db\Migration;

/**
 * Class m191202_050111_modify_geo_table
 */
class m191202_050111_modify_geo_table extends Migration
{
	/**
	 * {@inheritdoc}
	 */
	public function safeUp()
	{
		$this->addColumn('{{%geo}}', 'is_default', $this->boolean()->defaultValue(null)->null()->unique()->after('id'));
	}

	/**
	 * {@inheritdoc}
	 */
	public function safeDown()
	{
	}

}
