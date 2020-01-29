<?php

namespace app\widgets\catalog_filter;


use app\models\entity\Informers;
use app\models\entity\InformersValues;
use app\models\entity\ProductPropertiesValues;
use app\models\forms\CatalogFilter;
use app\models\tool\Debug;
use yii\base\Widget;
use yii\helpers\ArrayHelper;

class CatalogFilterWidget extends Widget
{
	public $template = 'default';

	public function run()
	{
		$filterModel = new CatalogFilter();
		if (\Yii::$app->request->isGet) {
			$filterModel->load(\Yii::$app->request->get());
		}

		$informers = Informers::find()->where(['is_active' => 1, 'is_show_filter' => 1])->all();

		return $this->render($this->template, [
			'filterModel' => $filterModel,
			'informers' => $informers,
		]);
	}
}