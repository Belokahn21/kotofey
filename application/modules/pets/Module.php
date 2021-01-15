<?php

namespace app\modules\pets;

use yii\helpers\Url;

class Module extends \yii\base\Module
{
    public $controllerNamespace = 'app\modules\pets\controllers';
    private $name = 'Питомцы';

    public function init()
    {
        parent::init();
    }

    public function menuIndex()
    {
        return [
            [
                'name' => 'Карточки питомцев',
                'url' => Url::to(['/admin/pets/pet-backend/index']),
            ],
            [
                'name' => 'Животные',
                'url' => Url::to(['/admin/pets/animal-backend/index']),
            ],
        ];
    }

    public function getName()
    {
        return $this->name;
    }
}
