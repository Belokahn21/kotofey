<?php


namespace app\modules\menu\widgets\Menu;


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

        $models = \Yii::$app->cache->getOrSet('menu-widget:id' . $menu_id, function () use ($menu_id) {
            return MenuItem::find()->where(['menu_item.menu_id' => $menu_id, 'menu_item.is_active' => 1, 'menu.is_active' => 1])->joinWith('menu')->orderBy(['sort' => SORT_DESC])->all();
        });

        return $this->render($this->view, [
            'models' => $models
        ]);
    }
}