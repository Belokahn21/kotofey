<?

namespace app\controllers;

use app\models\entity\Basket;
use app\models\entity\Favorite;
use app\models\entity\TodoList;
use app\models\tool\delivery\calc\CalculateDelllin;
use app\models\tool\Price;
use Dadata\Client;
use yii\filters\AccessControl;
use yii\helpers\Json;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\entity\Product;

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

    public function actionBookmark()
    {
        $POST = \Yii::$app->request->post();
        $favorite = new Favorite();
        $favorite->setProductId($POST['id']);
        if ($favorite->issetProduct()) {
            $favorite->delete();
            $result = Favorite::STATUS_REMOVE;
        } else {
            $favorite->save();
            $result = Favorite::STATUS_ADD;
        }


        return Json::encode([
            'result' => $result
        ]);
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

    public function actionPlus()
    {
        $POST = \Yii::$app->request->post();
        $product = Product::findOne($POST['id']);

        if ($product->count >= $_SESSION['basket'][$product->id]['count'] + 1) {
            $_SESSION['basket'][$product->id]['count']++;
        }


        return Json::encode([
            'htmldata' => [
                'summ' => Price::format($product->price * $_SESSION['basket'][$product->id]['count']),
                'allout' => $_SESSION['basket'][$product->id]['count'],
            ]
        ]);
    }

    public function actionMinus()
    {
        $POST = \Yii::$app->request->post();
        $product = Product::findOne($POST['id']);

        if ($_SESSION['basket'][$product->id]['count'] - 1 >= 0) {
            $_SESSION['basket'][$product->id]['count']--;
        }

        return Json::encode([
            'htmldata' => [
                'summ' => Price::format($product->price * $_SESSION['basket'][$product->id]['count']),
                'allout' => $_SESSION['basket'][$product->id]['count'],
            ]
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

    public function actionCalcdelivery()
    {
        $post = $_POST;

        $calc = new CalculateDelllin();
        $calc->calc([
            'arrivalPoint' => $post['kladr']
        ]);

        return Json::encode($calc);

    }

    public function actionRemovebookmark()
    {
        $POST = \Yii::$app->request->post();
        $favorite = new Favorite();
        $favorite->setProductId($POST['id']);
        if ($favorite->issetProduct()) {
            $favorite->delete();
            $result = Favorite::STATUS_REMOVE;
        }


        return Json::encode([
            'result' => $result
        ]);
    }
}
