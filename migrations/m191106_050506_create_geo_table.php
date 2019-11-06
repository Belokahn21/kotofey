<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%geo}}`.
 */
class m191106_050506_create_geo_table extends Migration
{
	/**
	 * {@inheritdoc}
	 */
	public function safeUp()
	{
		$this->createTable('{{%geo}}', [
			'id' => $this->primaryKey(),
			'name' => $this->string(255)->notNull(),
			'slug' => $this->string()->notNull(),
			'sort' => $this->integer()->defaultValue(500)->notNull(),
			'active' => $this->boolean()->defaultValue(true)->notNull(),
			'type_id' => $this->integer()->defaultValue(0)->notNull()->comment('link:geo_type'),
			'created_at' => $this->integer(),
			'updated_at' => $this->integer(),
		]);
	}

	/**
	 * {@inheritdoc}
	 */
	public function safeDown()
	{
		$this->dropTable('{{%geo}}');
	}
}
