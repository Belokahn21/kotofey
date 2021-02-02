<?php

namespace app\modules\catalog\models\form;


use app\modules\catalog\models\entity\PropertiesProductValues;
use app\modules\catalog\models\entity\SaveProductProperties;
use app\modules\catalog\models\entity\SaveProductPropertiesValues;
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
    public $params;

    public function rules()
    {
        return [
//            [['price_from', 'price_to', 'weight_from', 'weight_to', 'params'], 'integer'],
            [['price_from', 'price_to', 'weight_from', 'weight_to'], 'integer'],
            ['params', 'safe']
        ];
    }

    public function attributeLabels()
    {
        return [
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
        }
    }
}