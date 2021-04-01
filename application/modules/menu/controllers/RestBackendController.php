<?php

namespace app\modules\menu\controllers;

use yii\filters\Cors;
use yii\helpers\Json;
use yii\rest\Controller;

class RestBackendController extends Controller
{
    protected function verbs()
    {
        $verbs = parent::verbs();
        $verbs['index'] = ['GET'];
        $verbs['view'] = ['GET'];
        return $verbs;
    }

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['corsFilter'] = [
            'class' => Cors::className()
        ];
        return $behaviors;
    }

    public function actionIndex()
    {
        $menu = [
            ['title' => 'Главная стрница', 'href' => '/'],
            ['title' => 'Рабочий стол', 'href' => '/admin/'],
//			['title' => 'Города', 'href' => Url::to(['/admin/geo/geo-backend/index'])],
//			['title' => 'Временные зоны', 'href' => Url::to(['/admin/geo/timezone-backend/index'])],

//			['title' => 'Товары', 'href' => Url::to(['/admin/catalog/product-backend/index'])],
//			['title' => 'Разделы', 'href' => Url::to(['/admin/catalog/product-category-backend/index'])],
//			['title' => 'Свойства', 'href' => Url::to(['/admin/catalog/product-properties-backend/index'])],
//			['title' => 'Справочники', 'href' => Url::to(['/admin/catalog/product-informer-backend/index'])],
//			['title' => 'Значения справочников', 'href' => Url::to(['/admin/catalog/product-informer-value-backend/index'])],

//			['title' => 'Заказы', 'href' => Url::to(['/admin/order/order-backend/index'])],
//			['title' => 'Статусы заказа', 'href' => Url::to(['/admin/order/order-status-backend/index'])],
//			['title' => 'Склады', 'href' => Url::to(['/admin/stock/stock-backend/index'])],
//			['title' => 'Доставки', 'href' => Url::to(['/admin/delivery/delivery-backend/index'])],
//			['title' => 'Оплаты', 'href' => Url::to(['/admin/payment/payment-backend/index'])],
//			['title' => 'Поставщики', 'href' => Url::to(['/admin/vendors/vendors-backend/index'])],
//			['title' => 'Группы поставщиков', 'href' => Url::to(['/admin/vendors/vendors-group-backend/index'])],

//			['title' => 'Обращения', 'href' => Url::to(['/admin/support/support-backend/index'])],
//			['title' => 'Разделы', 'href' => Url::to(['/admin/support/support-category-backend/index'])],
//			['title' => 'Статусы', 'href' => Url::to(['/admin/support/support-status-backend/index'])],

//			['title' => 'Пользователи', 'href' => Url::to(['/admin/user/user-backend/index'])],
//			['title' => 'Группы', 'href' => Url::to(['/admin/user/user-group-backend/index'])],
//			['title' => 'Разрешения', 'href' => Url::to(['/admin/user/user-permission-backend/index'])],

//			['title' => 'Новости', 'href' => Url::to(['/admin/news/news-backend/index'])],
//			['title' => 'Рубрики', 'href' => Url::to(['/admin/news/news-category-backend/index'])],
//			['title' => 'Слайдеры', 'href' => Url::to(['/admin/content/slider-backend/index'])],
//			['title' => 'Изображения слайдера', 'href' => Url::to(['/admin/content/slider-images-backend/index'])],

//            ['title' => 'Короткие ссылки', 'href' => Url::to(['/admin/short_link/short-link-backend/index'])],
//			['title' => 'Поисковой контент', 'href' => Url::to(['/admin/feed/feed/index'])],

//			['title' => 'Вакансии', 'href' => Url::to(['/admin/vacancy/vacancy-backend/index'])],

//			['title' => 'Промокоды', 'href' => Url::to(['/admin/promocode/promocode-backend/index'])],

//			['title' => 'Акции', 'href' => Url::to(['/admin/promotion/promotion-backend/index'])],
//			['title' => 'Механики акций', 'href' => Url::to(['/admin/promotion/promotion-mechanics-backend/index'])],
        ];

        return Json::encode($menu);
    }
}
