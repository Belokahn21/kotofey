<?php


namespace app\modules\pets\widgets\AddPetForm;


use app\modules\pets\models\entity\Animal;
use app\modules\pets\models\entity\Pets;
use yii\base\Widget;
use yii\helpers\Url;

class AddPetFormWidget extends Widget
{
    public $view = 'default';
    public $action;

    public function run()
    {
        if (!$this->action) $this->action = Url::to(['/pets/pet/create']);

        $petModel = new Pets();
        $animals = Animal::find()->all();
        return $this->render($this->view, [
            'petModel' => $petModel,
            'animals' => $animals,
            'action' => $this->action,
        ]);
    }
}