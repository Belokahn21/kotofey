<?php

namespace app\models\forms;


use app\models\entity\ProductPropertiesValues;
use app\models\tool\Debug;
use yii\base\Model;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
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
        if (\Yii::$app->request->isPost) {
            if ($this->load(\Yii::$app->request->post())) {

                $ids = array();
                if($this->company){
                    $productsWithCompany = ProductPropertiesValues::find()->where(['property_id'=>'1','value' => $this->company])->select('product_id')->all();
                    $ids = ArrayHelper::getColumn($productsWithCompany, 'product_id');
                }


                if($this->type){
                    $productsWithType = ProductPropertiesValues::find()->where(['property_id'=>'3','value' => $this->type, 'product_id'=>$ids])->select('product_id')->all();
                    $ids = ArrayHelper::getColumn($productsWithType, 'product_id');
                }


                // set price
                if (!empty($this->price_from)) {
                    $query->where(['>=', 'price', $this->price_from]);
                }

                if (!empty($this->price_to)) {
                    $query->andWhere(['<=', 'price', $this->price_to]);
                }


                $query->andWhere(['id' => $ids]);

            }
        }
    }
}