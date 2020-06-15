<?php

namespace app\controllers;

use Yii;
use app\models\entity\InformersValues;
use app\models\entity\ProductPropertiesValues;
use app\models\entity\SearchQuery;
use app\models\forms\SaleProductForm;
use app\models\tool\Backup;
use app\widgets\notification\Alert;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\entity\Product;

class AdminController extends Controller
{
    public $layout = "admin";

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['Administrator', 'Developer'],
                    ],
                    [
                        'allow' => false,
                        'roles' => ['?'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
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

    public function actionIndex()
    {
        $last_search = SearchQuery::find()->orderBy(['created_at' => SORT_DESC])->limit(5)->all();

        if (Yii::$app->request->get('save_dump') == 'Y') {
            $backup = new Backup();
            if ($backup->isOverSize()) {
                $backup->clearDumpCatalog();
            }

            $backup->createDumpDatabase();

            if (Yii::$app->request->get('out') == 'Y') {
                $name = Yii::getAlias('@app') . $backup->getNameDirDumps() . $backup->getNameFile();
                header('Content-Type: application/octet-stream');
                header("Content-Transfer-Encoding: Binary");
                header("Content-disposition: attachment; filename=\"" . $backup->getNameFile() . "\"");
                readfile($name);
                exit;
            }


            return $this->redirect(['admin/index']);
        }

        return $this->render('index', [
            'last_search' => $last_search
        ]);
    }


    public function actionCache()
    {
        Yii::$app->cache->flush();
        return $this->redirect('/');
    }


    public function actionSaleProduct()
    {
        $model = new SaleProductForm();
        $sales = InformersValues::find()->where(['informer_id' => '10', 'active' => 1])->all();

        if (\Yii::$app->request->isPost) {
            if ($model->load(\Yii::$app->request->post())) {
                if ($model->validate()) {
                    $selectedItems = ProductPropertiesValues::find()->where(['value' => $model->sale_id, 'property_id' => 11])->all();

                    $products = Product::find()->where(['id' => ArrayHelper::getColumn($selectedItems, 'product_id')])->all();
                    foreach ($products as $product) {
                        $transaction = Yii::$app->db->beginTransaction();
                        $product->scenario = Product::SCENARIO_UPDATE_PRODUCT;
                        $product->discount_price = null;
                        if ($product->validate()) {
                            if ($product->update() === false) {
                                $transaction->rollBack();
                                return false;
                            }
                        }
                        if (!ProductPropertiesValues::findOne(['value' => $model->sale_id, 'product_id' => $product->id, 'property_id' => 11])->delete()) {
                            $transaction->rollBack();
                            return false;
                        }

                        $transaction->commit();
                    }

                    Alert::setSuccessNotify('Товары сняты с акции');
                    return $this->refresh();
                }
            }
        }

        return $this->render('sale-product', [
            'model' => $model,
            'sales' => $sales
        ]);
    }
}
