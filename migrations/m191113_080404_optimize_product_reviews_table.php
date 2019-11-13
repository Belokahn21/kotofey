<?php

use yii\db\Migration;

/**
 * Class m191113_080404_optimize_product_reviews_table
 */
class m191113_080404_optimize_product_reviews_table extends Migration
{

	public function safeUp()
	{
		$this->renameColumn('{{%product_reviews}}', 'product', 'product_id');
		$this->dropColumn('{{%product_reviews}}', 'paid');
		$this->addColumn('{{%product_reviews}}', 'rate', $this->integer()->defaultValue(0)->notNull()->after('images'));
		$this->addColumn('{{%product_reviews}}', 'author', $this->string()->defaultValue(255)->notNull()->after('text'));
	}

	public function safeDown()
	{
		$this->renameColumn('{{%product_reviews}}', 'product_id', 'product');
		$this->dropColumn('{{%product_reviews}}', 'rate');
		$this->dropColumn('{{%product_reviews}}', 'author');
		$this->addColumn('{{%product_reviews}}', 'paid', $this->boolean()->defaultValue(0)->notNull()->after('images'));
		return false;
	}
}
