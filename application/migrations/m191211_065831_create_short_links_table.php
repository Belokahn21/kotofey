<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%short_links}}`.
 */
class m191211_065831_create_short_links_table extends Migration
{
	/**
	 * {@inheritdoc}
	 */
	public function safeUp()
	{
		$this->createTable('{{%short_links}}', [
			'id' => $this->primaryKey(),
			'is_active' => $this->boolean()->defaultValue(true),
			'sort' => $this->integer()->defaultValue(500),
			'link' => $this->text()->notNull(),
			'short_code' => $this->string(150)->unique()->notNull(),
			'created_at' => $this->integer(),
			'updated_at' => $this->integer(),
		]);
	}

	/**
	 * {@inheritdoc}
	 */
	public function safeDown()
	{
		$this->dropTable('{{%short_links}}');
	}
}
