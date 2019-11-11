<?

namespace app\controllers;

use app\models\entity\Basket;
use app\models\entity\BasketItem;
use app\models\entity\Favorite;
use app\models\entity\Informers;
use app\models\entity\InformersValues;
use app\models\entity\ProductProperties;
use app\models\entity\ProductPropertiesValues;
use app\models\entity\TodoList;
use app\models\tool\Debug;
use app\models\tool\delivery\calc\CalculateDelllin;
use app\models\tool\Price;
use Dadata\Client;
use phpDocumentor\Reflection\DocBlock\Tags\Property;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\entity\Product;
use yii\web\HttpException;

class AjaxController extends Controller
{
    public $layout = "ajax";

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
//                    'tobasket' => ['post'],
                ],
            ],
        ];
    }

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public function actionRemoveFromBasket($product_id)
    {
        if (\Yii::$app->request->isAjax) {
            $product = Product::findOne($product_id);
            if (!$product) {
                throw new HttpException(404, 'Товар не найден');
            }

            Basket::getInstance()->delete($product_id);
            if (Basket::getInstance()->delete($product_id) and !Basket::getInstance()->exist($product_id)) {
                return true;
            }
        }
        return false;
    }

    public function actionAddToBasket($product_id, $count)
    {
        if (\Yii::$app->request->isAjax) {
            $product = Product::findOne($product_id);
            if (!$product) {
                throw new HttpException(404, 'Товар не найден');
            }

            if (!$product->vitrine) {
                if ($product->count - $count <= 0) {
                    return false;
                }
            }

            $basketItem = new BasketItem();
            $basketItem->setProductId($product->id);
            $basketItem->setCount($count);

            $basket = new Basket();
            if ($basket->exist($basketItem->getProductId())) {
                $basket->update($basketItem, $count);
            } else {
                $basket->add($basketItem);
            }

            return true;
        }

        return false;
    }

    public function actionTobasket()
    {
        if (\Yii::$app->request->isPost) {

            $POST = \Yii::$app->request->post();
            $product = Product::findOne($POST['id']);
            if (($product->count - 1) >= 0) {
                $basket = new Basket();
                $basket->product = Product::findOne($POST['id']);
                $basket->count = 1;
                $basket->add();

                $result = [
                    'status' => true,
                    'htmlData' => $this->renderFile('@app/views/ajax/basket.php'),
                ];
            } else {
                $result = [
                    'status' => false,
                ];
            }


            return Json::encode($result);
        } else {

            $GET = \Yii::$app->request->get();
            $product = Product::findOne($GET['id']);
            if (($product->count - 1) >= 0) {

                $basket = new Basket();
                $basket->product = Product::findOne($GET['id']);
                $basket->count = 1;
                $basket->add();

            }

        }
    }

    public function actionRemovetodo()
    {
        $POST = \Yii::$app->request->post();
        return Json::encode(TodoList::findOne($POST['id'])->delete());
    }

    public function actionClosetodo()
    {
        $POST = \Yii::$app->request->post();
        $todoObject = TodoList::findOne($POST['id']);
        $todoObject->close = !$todoObject->close;
        return Json::encode($todoObject->update());
    }

    public function actionGeo()
    {

        $post = \Yii::$app->db->createCommand("select * from `KLADR` where `name` like '" . \Yii::$app->request->post()['position'] . "'")->queryAll();

        return Json::encode([
            'items' => $post
        ]);
    }

    public function actionKladr()
    {
        $post = $_POST;
        $client = new Client(new \GuzzleHttp\Client(), [
            'token' => '21ebc5ed8ce5d22637d7c721b2a20621bbe00646',
            'secret' => '33b0c8d576de9eebe44a4fdf5b8ead48f792d377',
        ]);

        $response = $client->cleanAddress($post['word']);

        return Json::encode([
            'address' => $response
        ]);
    }

    public function actionFilter()
    {

        if (!array_key_exists('CatalogFilter', $_POST)) {
            throw new \Exception('Массив днных не пришёл');
        }
        $form = $_POST['CatalogFilter'];
        $ar_bank_products_ids = array();
        $arKeyToPropertyId = array(
            'company' => 1,
            'type' => 3,
            'line' => 4,
            'taste' => 5,
        );

        foreach ($arKeyToPropertyId as $key => $id) {

            if (array_key_exists($key, $form) && !empty($form[$key])) {

                $query = ProductPropertiesValues::find()->where([
                    'value' => $form[$key],
                    'property_id' => $id
                ])->select(['product_id'])->all();

                $arListIds = ArrayHelper::getColumn($query, 'product_id');


                if (count($ar_bank_products_ids) > 0) {
                    $ar_bank_products_ids = array_intersect($arListIds, $ar_bank_products_ids);
                } else {
                    $ar_bank_products_ids = $arListIds;
                }

            }
        }


        return Json::encode([
//            'company' => $selectCompany
        ]);
    }
}
