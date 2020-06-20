<?php

namespace app\modules\news\widgets\last_news;


use app\models\entity\News;
use yii\base\Widget;

class LastNewsWidget extends Widget
{
    public $view = 'default';
    public $limit = 3;
    public $time_cache;

    public function run()
    {
        $cache = \Yii::$app->cache;
        $key = LastNewsWidget::className();
        $this->time_cache = 3600 * 60 * 24;

        $news = $cache->getOrSet($key, function () {
            return News::find()->limit($this->limit)->orderBy(['created_at' => SORT_DESC])->all();
        }, $this->time_cache);

        return $this->render($this->view, [
            'news' => $news
        ]);
    }
}