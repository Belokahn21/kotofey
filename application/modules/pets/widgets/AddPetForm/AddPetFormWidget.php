<?php


namespace app\modules\pets\widgets\AddPetForm;


use app\modules\pets\models\entity\Animal;
use app\modules\pets\models\entity\Pets;
use yii\base\Widget;

class AddPetFormWidget extends Widget
{
    public $view = 'default';

    public function run()
    {
        $petModel = new Pets();
        $animals = Animal::find()->all();
        return $this->render($this->view, [
            'petModel' => $petModel,
            'animals' => $animals,
        ]);
    }
}