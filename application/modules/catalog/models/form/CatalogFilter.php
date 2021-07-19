<?php

namespace app\modules\catalog\models\form;

use app\modules\catalog\models\entity\PropertiesProductValues;
use yii\base\Model;
use yii\db\ActiveQuery;

/**
 * @property integer $available
 * @property integer $price_from
 * @property integer $price_to
 * @property integer $params
 */
class CatalogFilter extends Model
{
    public $available;
    public $price_from;
    public $price_to;
    public $weight_from;
    public $weight_to;
    public $params;

    public function rules()
    {
        return [
            [['price_from', 'price_to', 'weight_from', 'weight_to'], 'integer'],
            ['params', 'safe']
        ];
    }

    public function attributeLabels()
    {
        return [
            'available' => 'В наличии',
            'params' => 'Справочник',
            'price_from' => 'Цена от',
            'price_to' => 'Цена до',
            'weight_from' => 'Вес от',
            'weight_to' => 'Вес до',
        ];
    }


    /**
     * @param ActiveQuery $query
     */
    public function applyFilter(&$query)
    {
        if ($this->load(\Yii::$app->request->get())) {

            $valuesQuery = PropertiesProductValues::find()->select(['product_id']);
            $iter = 0;

            if ($this->params) {
                foreach ($this->params as $propId => $values) {
                    if ($values) {
                        $valuesQuery->orFilterWhere(['value' => $values, 'property_id' => $propId]);
                        $iter++;
                    }
                }
            }

            $valuesQuery->groupBy('product_id');
//            $valuesQuery->having("count(*) = " . $iter);

            $query->innerJoin(['sq' => $valuesQuery], 'sq.product_id = product.id');

            if ($this->price_from and $this->price_to) $query->andFilterWhere(['between', 'price', $this->price_from, $this->price_to]);
            if ($this->available == 'Y') $query->andFilterWhere(['>', 'count', 0]);
        }
    }
}