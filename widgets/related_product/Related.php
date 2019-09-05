<?
/**
 * Developer: Konstantin Vasin by PhpStorm
 * Company: Altasib
 * Time: 1:00
 */

namespace app\widgets\related_product;


use app\models\entity\Product;
use yii\base\Widget;
use yii\db\Expression;

class Related extends Widget
{
    public $category;

    public function run()
    {
        $products = Product::find()->where(['category' => $this->category])->limit(4)->orderBy(new Expression('rand()'))->all();
        if ($products) {
            return $this->render('default', [
                'products' => $products
            ]);
        }
    }
}