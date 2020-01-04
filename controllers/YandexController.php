<?php

namespace app\controllers;

use yii\web\Controller;

class YandexController extends Controller
{
    public $layout = false;

    public function actionExport()
    {
//        \Yii::$app->response->format = \yii\web\Response::FORMAT_XML;

        $content = '<?xml version="1.0" encoding="UTF-8"?>
<yml_catalog date="2019-11-01 17:22">
    <shop>
        <name>BestSeller</name>
        <company>Tne Best inc.</company>
        <url>http://best.seller.ru</url>
        <currencies>
            <currency id="RUR" rate="1"/>
            <currency id="USD" rate="60"/>
        </currencies>
        <categories>
            <category id="1">Книги</category>
            <category id="2" parentId="1">Детективы</category>
            <category id="3" parentId="1">Боевики</category>
            <category id="4">Видео</category>
            <category id="5" parentId="4">Комедии</category>
            <category id="6">Принтеры</category>
            <category id="7">Оргтехника</category>
        </categories>
        <delivery-options>
            <option cost="200" days="1"/>
        </delivery-options>
        <offers>
            <offer id="9012">
                <name>Мороженица Brand 3811</name>
                <url>http://best.seller.ru/product_page.asp?pid=12345</url>
                <price>8990</price>
                <currencyId>RUR</currencyId>
                <categoryId>10</categoryId>
                <delivery>true</delivery>
                <delivery-options>
                    <option cost="300" days="1" order-before="18"/>
                </delivery-options>
                <param name="Цвет">белый</param>
                <weight>3.6</weight>
                <dimensions>20.1/20.551/22.5</dimensions>
                </offer>
        </offers>
        <gifts>
            <!-- подарки не из прайс?листа -->
        </gifts>
        <promos>
            <!-- промоакции -->
        </promos>
    </shop>
</yml_catalog>';
        return iconv('utf-8', 'windows-1251//TRANSLIT//IGNORE', $content);
    }
}