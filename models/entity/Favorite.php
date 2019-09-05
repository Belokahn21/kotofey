<?
/**
 * Developer: Konstantin Vasin by PhpStorm
 * Company: Altasib
 * Time: 18:10
 */

namespace app\models\entity;


use app\models\tool\Debug;

class Favorite
{

    const STATUS_ADD = 1;
    const STATUS_REMOVE = 2;

    private $productId;

    public function save()
    {
        \Yii::$app->session->open();
        $_SESSION['favorite'][$this->productId] = $this->productId;
    }

    public function delete()
    {
        unset($_SESSION['favorite'][$this->productId]);
    }

    public function listProducts()
    {
        $items = [];
        if (isset($_SESSION['favorite'])) {
            foreach ($_SESSION['favorite'] as $id) {
                $items[] = Product::findOne($id);
            }
        }

        return $items;
    }

    public function count()
    {
        return count($_SESSION['favorite']);
    }

    public static function isProductInFavorite($productId)
    {
        if (isset($_SESSION['favorite'][$productId])) {
            return true;
        }
        return false;
    }

    public function setProductId($productId)
    {
        $this->productId = $productId;
    }

    public function getProductId()
    {
        return $this->productId;
    }

    public function issetProduct()
    {
        return (!empty($_SESSION['favorite'][$this->productId])) ? true : false;
    }
}