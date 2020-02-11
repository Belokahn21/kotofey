<?php

namespace app\widgets\catalog_filter;


use app\models\entity\Category;
use app\models\entity\Informers;
use app\models\entity\Product;
use app\models\entity\ProductProperties;
use app\models\entity\ProductPropertiesValues;
use app\models\forms\CatalogFilter;
use app\models\tool\Debug;
use yii\base\Widget;
use yii\helpers\ArrayHelper;

/**
 * CatalogFilterWidget class
 * @property Category $category
 */
class CatalogFilterWidget extends Widget
{
	public $template = 'default';
	public $category;

	public function run()
	{
		$filterModel = new CatalogFilter();
		if (\Yii::$app->request->isGet) {
			$filterModel->load(\Yii::$app->request->get());
		}
		$currentInformers = null;
		$products = null;
		$productPropertiesValues = null;
		$currentProperties = null;
		$properties = null;

		//список свойств у которых справочники
		if ($this->category) {
			$sub_categories = $this->category->subsections($this->category->id);
			$arSubCategories = ArrayHelper::getColumn($sub_categories, 'id');
			$products = Product::find()->where(['category_id' => $arSubCategories])->all();

			if ($products) {
				$productPropertiesValues = ProductPropertiesValues::find()->where(['product_id' => ArrayHelper::getColumn($products, 'id')])->all();
			}

			if ($productPropertiesValues) {
				$currentProperties = ArrayHelper::getColumn($productPropertiesValues, 'property_id');
			}


			if ($currentProperties) {
				$properties = ProductProperties::find()->where(['id' => $currentProperties, 'type' => 1])->all();
			}

			if ($properties) {
				$currentInformers = ArrayHelper::getColumn($properties, 'informer_id');
			}

		}


		$informers = Informers::find()->where(['is_active' => 1, 'is_show_filter' => 1]);

		if ($currentInformers) {
			$informers->andWhere(['id' => $currentInformers]);
		}

		$informers = $informers->all();
		return $this->render($this->template, [
			'filterModel' => $filterModel,
			'informers' => $informers,
			'productPropertiesValues' => $productPropertiesValues,
		]);
	}
}