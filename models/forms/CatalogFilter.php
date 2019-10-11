<?php

namespace app\models\forms;


use app\models\entity\ProductPropertiesValues;
use app\models\tool\Debug;
use yii\base\Model;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\db\Expression;
use yii\helpers\ArrayHelper;

class CatalogFilter extends Model
{
    public $price_from;
    public $price_to;
    public $type;
    public $company;
    public $line;
    public $taste;
    public $weight_from;
    public $weight_to;

    public function rules()
    {
        return [
            [['price_from', 'price_to', 'weight_from', 'weight_to'], 'integer'],

            [['type', 'company', 'line', 'taste'], 'safe'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'price_from' => 'Цена от',
            'price_to' => 'Цена до',
            'type' => 'Тип',
            'company' => 'Производитель',
            'weight_from' => 'Вес от',
            'weight_to' => 'Вес до',
            'line' => 'Линейка',
            'taste' => 'Вкус',
        ];
    }


    /**
     * @param ActiveQuery $query
     */
    public function applyFilter(&$query)
    {
        if (\Yii::$app->request->isGet) {
            if ($this->load(\Yii::$app->request->get())) {

                $list_property_ids = array();
                $list_attribute_to_property_id = array(
                    'company' => 1,
                    'type' => 3,
                    'line' => 4,
                    'taste' => 5,
                );

                // set price
                if (!empty($this->price_from)) {
                    $query->where(['>=', 'price', $this->price_from]);
                }

                if (!empty($this->price_to)) {
                    $query->andWhere(['<=', 'price', $this->price_to]);
                }

                // properties
                $values = ProductPropertiesValues::find()->select('product_id');
                $properties_ids = array();
                $value_list = array();
                $iter = 0;

                foreach ($this->getAttributes() as $attributeKey => $hisValue) {

                    if (!empty($hisValue) && array_key_exists($attributeKey, $list_attribute_to_property_id)) {
                        $properties_ids[] = $list_attribute_to_property_id[$attributeKey];
                        $value_list = array_merge($value_list, $hisValue);
                        $iter++;
                    }
                }

                $values->orWhere([
                    'property_id' => $properties_ids,
                    'value' => $value_list
                ]);

//                if (!empty($this->weight_from) or !empty($this->weight_to)) {
//                    $values->andWhere(new Expression('`property_id`="2" and CAST(`value` AS INT) > "' . $this->weight_from . '" and CAST(`value` AS INT) < "' . $this->weight_to . '"'));
//                }


                $values->groupBy('product_id');
                $values->having("count(*) = " . $iter);

//                Debug::printFile($values->prepare(\Yii::$app->db->queryBuilder)->createCommand()->rawSql);
                $values = $values->all();
                $list_property_ids = array_merge($list_property_ids, ArrayHelper::getColumn($values, 'product_id'));

                if (is_array($list_property_ids)) {
                    $query->andWhere([
                        'id' => $list_property_ids
                    ]);
                }
            }
        }
    }
}