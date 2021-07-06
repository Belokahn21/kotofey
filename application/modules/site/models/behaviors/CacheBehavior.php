<?php

namespace app\modules\site\models\behaviors;


use yii\base\Behavior;
use yii\db\ActiveRecord;

class CacheBehavior extends Behavior
{
    public $tags = [];

    public function events()
    {
        return [
            ActiveRecord::EVENT_AFTER_UPDATE => 'flush',
            ActiveRecord::EVENT_AFTER_INSERT => 'flush',
        ];
    }

    public function flush($event)
    {
        if ($this->tags && is_array($this->tags) && count($this->tags) > 0) {
            foreach ($this->tags as $tag) {
                \Yii::$app->cache->delete($tag);
            }
        } else {
            \Yii::$app->cache->flush();
        }
    }
}