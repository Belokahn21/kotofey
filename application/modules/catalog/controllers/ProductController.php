<?php

namespace app\modules\catalog\controllers;

use app\modules\catalog\models\entity\NotifyAdmission;
use app\modules\catalog\models\entity\Properties;
use app\modules\catalog\models\entity\PropertiesProductValues;
use app\modules\catalog\models\helpers\ProductHelper;
use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\web\Controller;
use app\modules\site\models\tools\System;
use app\models\tool\seo\Attributes;
use app\models\tool\seo\og\OpenGraph;
use app\models\tool\seo\og\OpenGraphProduct;
use app\modules\catalog\models\entity\ProductCategory;
use app\modules\catalog\models\entity\Product;
use yii\web\Response;

class ProductController extends Controller
{
    public function actionView($id)
    {
        $product = Product::findBySlug($id);
        if (!$product instanceof Product) throw new \yii\web\NotFoundHttpException("Товар не найден.");

        $category = ProductCategory::findOne($product->category_id);

        if (!empty($product->seo_description)) {
            Attributes::metaDescription($product->seo_description);
        } else {
            if (!empty($product->description)) {
                Attributes::metaDescription($product->description);
            } else {
                Attributes::metaDescription(sprintf('В нашем интернет-магазине зоотоваров в продаже  имеется %s по низкой цене в Барнауле. За каждую покупку выполучите 5%% бонусов, а мы доставим бесплатно!', $product->name));
            }
        }

        if (!empty($product->seo_keywords)) {
            Attributes::metaKeywords($product->seo_keywords);
        } else {
            Attributes::metaKeywords(explode(';', sprintf("купить %s в барнауле;интернет-зоомагазин;зоомагазин интернет барнаул;анго зоомагазин интернет барнаул;интернет зоомагазин с доставкой", $product->name)));
        }

        Attributes::canonical(System::protocol() . "://" . System::domain() . "/product/" . $product->slug . "/");

        OpenGraphProduct::title($product->display);
        if (!empty($product->description)) {
            OpenGraph::description($product->description);
            Attributes::metaDescription($product->description);
        }
        OpenGraphProduct::type();
        OpenGraphProduct::url(System::protocol() . "://" . System::domain() . "/" . Yii::$app->controller->action->id . "/" . $product->slug . "/");
        OpenGraphProduct::amount($product->price);
        OpenGraphProduct::currency('RUB');

        if ($product->media) OpenGraphProduct::image(ProductHelper::getImageUrl($product, true));

        // todo: отсюда переделать на новые свойства
        $properties = PropertiesProductValues::find()
            ->where(['product_id' => $product->id])
            ->andWhere(['not in', 'property_id', ArrayHelper::getColumn(Properties::find()->select('id')->where(['is_show_site' => false])->all(), 'id')])
            ->all();
        ProductHelper::addVisitedItem($product->id);

        return $this->render('view', [
            'product' => $product,
            'category' => $category,
            'properties' => $properties,
        ]);
    }


    public function actionSaveNotifyAdmission()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $model = new NotifyAdmission();

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            if ($model->validate() && $model->save()) {
                return Json::encode([
                    'success' => 1,
                ]);
            } else {
                return Json::encode([
                    'false' => 1,
                    'message' => $model->getErrors()
                ]);
            }
        }
    }


    public function actionRemoveNotifyAdmission()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $data = Yii::$app->request->post();

        if (NotifyAdmission::findOne(['email' => $data['email'], 'product_id' => $data['product_id']])->delete()) return Json::encode([
            'success' => 1,
        ]);
    }
}