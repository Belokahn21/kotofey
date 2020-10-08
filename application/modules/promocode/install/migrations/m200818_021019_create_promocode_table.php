<?php

use yii\db\Migration;

class m200818_021019_create_promocode_table extends Migration
{
	public function safeUp()
	{
		$this->createTable('{{%promocode}}', [
			'id' => $this->primaryKey(),
			'code' => $this->string(255)->unique(),
			'count' => $this->integer()->defaultValue(0)->notNull(),
			'discount' => $this->integer()->notNull()->defaultValue(0),
			'created_at' => $this->integer(),
			'updated_at' => $this->integer(),
		]);
	}

	public function safeDown()
	{
		$this->dropTable('{{%promocode}}');
	}
}
