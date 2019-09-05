<?
/**
 * Developer: Konstantin Vasin by PhpStorm
 * Company: Altasib
 * Time: 19:52
 */

namespace app\models\entity;


use yii\base\Model;
use yii\db\ActiveRecord;

class Search extends Model
{
    public $search;
    public $category;
    public $pricefrom;
    public $priceto;

    public function rules()
    {
        return [
            [['search', 'category', 'pricefrom', 'priceto'], 'string']
        ];
    }

    public function attributeLabels()
    {
        return [
            'search' => 'Название товара',
            'category' => 'Раздел',
            'pricefrom' => 'Цена от',
            'priceto' => 'Цена до',
        ];
    }

    public function search()
    {
        $products = Product::find();
        $products = $this->setFilter($products);

        return $products->all();
    }

    public function setFilter($products)
    {
        if (!empty($this->search)) {

            $phrase = $this->search;
            $words = explode(" ", $phrase);

            if (count($words) > 1) {

                foreach ($words as $word) {
                    $products->andWhere(['like', 'name', $word]);
                }

            } else {
                $products->where(['like', 'name', $this->search]);
            }

        }
//        if (!empty($this->category)) {
//            $products->andWhere(['category' => $this->category]);
//        }
//        if (!empty($this->pricefrom)) {
//            $products->andWhere(['>', 'price', $this->pricefrom]);
//        }
//        if (!empty($this->priceto)) {
//            $products->andWhere(['<', 'price', $this->priceto]);
//        }

        return $products;

    }


    private function formatSearchPhrase()
    {

    }
}