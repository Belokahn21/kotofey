<?php


namespace app\modules\menu\widgets\Menu;


use app\modules\menu\models\entity\Menu;
use app\modules\menu\models\entity\MenuItem;
use yii\base\Widget;

class MenuWidget extends Widget
{
    public $view = 'default';
    public $menu_id;
    public $cache_time = 3600 * 24;

    public function run()
    {
        $menu_id = $this->menu_id;

        $models = \Yii::$app->cache->getOrSet('menu-widget', function () use ($menu_id) {
            return MenuItem::find()->where(['menu.id' => $menu_id])->with('menu')->all();
        });

        return $this->render($this->view, [
            'models' => $models
        ]);
    }
}