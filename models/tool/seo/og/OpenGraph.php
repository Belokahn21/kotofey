<?php

namespace app\models\tool\seo\og;


use yii\helpers\StringHelper;

class OpenGraph
{
    public static function image($content)
    {
        return \Yii::$app->view->registerMetaTag([
            'property' => 'og:image',
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


    public static function type($content)
    {
        return \Yii::$app->view->registerMetaTag([
            'property' => 'og:type',
            'content' => $content
        ]);
    }


    public static function title($content)
    {
        return \Yii::$app->view->registerMetaTag([
            'property' => 'og:title',
            'content' => $content
        ]);
    }


    public static function description($content)
    {
        return \Yii::$app->view->registerMetaTag([
            'property' => 'og:description',
            'content' => StringHelper::truncate(strip_tags($content), 300, "...")
        ]);

    }
}