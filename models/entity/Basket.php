<?

namespace app\models\entity;


use app\models\tool\Debug;

/**
 * Basket model
 *
 * @property Product $product
 * @property integer $count
 * @property Promo $promo
 */
class Basket
{
    public $product;
    public $count;

    public static function getInstance()
    {
        return new Basket();
    }

    public function add()
    {
        \Yii::$app->session->open();
        $_SESSION['basket'][$this->product->id]['product'] = $this->product;
        $_SESSION['basket'][$this->product->id]['count'] = $this->count;
    }

    public function listItems()
    {
        $items = [];
        if (!empty($_SESSION['basket'])) {
            foreach ($_SESSION['basket'] as $id => $item) {
                $basket = new Basket();
                $basket->product = $item['product'];
                $basket->count = $item['count'];
                $items[] = $basket;
            }
        }

        return $items;
    }

    public function addPromo(Promo $promo)
    {
        $_SESSION['promobasket'] = $promo;
    }

    public function getPromo()
    {
        return \Yii::$app->session->get('promobasket');
    }

    public function clear()
    {
        unset($_SESSION['basket']);
    }

    public static function count()
    {
        return count(\Yii::$app->session->get('basket'));
//        return count($_SESSION['basket']);
    }

    public function isEmpty()
    {
        if (!isset($_SESSION['basket']) or $this->count() == 0) {
            return true;
        } else {
            return false;
        }
    }


    public function cash()
    {
        $cash = 0;

        /* @var $promo Promo */
        $promo = $this->getPromo();
        if (!empty($_SESSION['basket'])) {
            foreach ($_SESSION['basket'] as $id => $item) {
                if ($promo) {
                    $cash += $item['product']->price - (($item['product']->price * $promo->discount) / 100);
                } else {
                    $cash += $item['product']->price;
                }
            }
        }

        return $cash;
    }
}