<?php

namespace app\models\tool\import;


class Forza10
{
	public function getPricePath()
	{
		return \Yii::getAlias('@app/tmp/price/forza/forza.csv');
	}

	public function update()
	{

	}
}