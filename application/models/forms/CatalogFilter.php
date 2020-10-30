<?php

namespace app\models\forms;


use app\modules\catalog\models\entity\ProductProperties;
use app\modules\catalog\models\entity\ProductPropertiesValues;
use app\modules\site\models\tools\Debug;
use phpDocumentor\Reflection\DocBlock\Tags\Property;
use yii\base\Model;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\db\Expression;
use yii\helpers\ArrayHelper;

class CatalogFilter extends Model
{
	public $price_from;
	public $price_to;
	public $weight_from;
	public $weight_to;
	public $informer;

	public function rules()
	{
		return [
			[['price_from', 'price_to', 'weight_from', 'weight_to', 'informer'], 'integer'],
		];
	}

	public function attributeLabels()
	{
		return [
			'informer' => 'Справочник',
			'price_from' => 'Цена от',
			'price_to' => 'Цена до',
			'weight_from' => 'Вес от',
			'weight_to' => 'Вес до',
		];
	}


	/**
	 * @param ActiveQuery $query
	 */
	public function applyFilter(&$query, $requsetParams)
	{
		if ($this->load($requsetParams)) {

			$ar_product_id = array();

			// properties
			$values = ProductPropertiesValues::find()->select('product_id');
			$properties_ids = array();
			$value_list = array();
			$iter = 0;

			foreach ($this->informer as $informer_id => $arValues) {
				if (is_array($arValues)) {
					$properties_ids[] = ProductProperties::find()->where(['informer_id' => $informer_id])->one()->id;
					$value_list = array_merge($value_list, $arValues);
					$iter++;
				}
			}

			$values->orWhere([
				'property_id' => $properties_ids,
				'value' => $value_list
			]);

			$values->groupBy('product_id');
			$values->having("count(*) = " . $iter);

			$values = $values->all();
			$ar_product_id = array_merge($ar_product_id, ArrayHelper::getColumn($values, 'product_id'));

			if (is_array($ar_product_id)) {
				$query->andWhere([
					'id' => $ar_product_id
				]);
			}
		}
	}
}