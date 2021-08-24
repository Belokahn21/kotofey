<?php

namespace app\modules\site;

use yii\helpers\Url;

/**
 * site module definition class
 */
class Module extends MainModule
{
    public $controllerNamespace = 'app\modules\site\controllers';
    private $name = 'Сайт';

    public function getName(): string
    {
        return $this->name;
    }

    public function menuIndex()
    {
        return [
            ['name' => 'Лог файл', 'url' => Url::to(['/admin/site/site-backend/log'])],
        ];
    }
}
