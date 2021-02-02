<?php

namespace app\modules\seo\models\tools\og;


class OpenGraphProduct
{
    public static function type()
    {
        return \Yii::$app->view->registerMetaTag([
            'property' => 'og:type',
            'content' => 'product'
        ]);
    }

    public static function title($content)
    {
        return \Yii::$app->view->registerMetaTag([
            'property' => 'og:title',
            'content' => $content
        ]);
    }

    public static function url($content)
    {
        return \Yii::$app->view->registerMetaTag([
            'property' => 'og:url',
            'content' => $content
        ]);
    }

    public static function image($content)
    {
        return \Yii::$app->view->registerMetaTag([
            'property' => 'og:image',
            'content' => $content
        ]);
    }

    public static function amount($content)
    {
        return \Yii::$app->view->registerMetaTag([
            'property' => 'product:price:amount',
            'content' => $content
        ]);
    }

    public static function currency($content)
    {
        return \Yii::$app->view->registerMetaTag([
            'property' => 'product:price:currency',
            'content' => $content
        ]);
    }
}