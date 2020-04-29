<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%vaccination}}`.
 */
class m191217_050309_create_vaccination_table extends Migration
{
	/**
	 * {@inheritdoc}
	 */
	public function safeUp()
	{
		$this->createTable('{{%vaccination}}', [
			'id' => $this->primaryKey(),
			'sort' => $this->integer()->defaultValue(500),
			'is_active' => $this->boolean()->defaultValue(true),
			'city_id' => $this->integer()->null(),
			'title' => $this->string()->notNull(),
			'description' => $this->text()->null(),
			'price' => $this->string(255)->null(),
			'image' => $this->string(255)->null(),
			'created_at' => $this->integer(),
			'updated_at' => $this->integer(),
		]);
	}

	/**
	 * {@inheritdoc}
	 */
	public function safeDown()
	{
		$this->dropTable('{{%vaccination}}');
	}
}
