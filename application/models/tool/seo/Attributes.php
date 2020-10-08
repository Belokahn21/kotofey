<?php
/**
 * Developer: Konstantin Vasin by PhpStorm
 * Company: Altasib
 * Time: 23:14
 */

namespace app\models\tool\seo;


class Attributes
{
    public static function metaKeywords($content)
    {
        if (is_array($content)) {
            $content = implode(", ", $content);
        }
        \Yii::$app->view->registerMetaTag([
            'name' => 'keywords',
            'content' => $content
        ]);
    }

    public static function metaDescription($content)
    {
        \Yii::$app->view->registerMetaTag([
            'name' => 'description',
            'content' => $content
        ]);
    }

    public static function canonical($content)
    {
        \Yii::$app->view->registerLinkTag([
            'rel' => 'canonical',
            'href' => $content
        ]);
    }
}