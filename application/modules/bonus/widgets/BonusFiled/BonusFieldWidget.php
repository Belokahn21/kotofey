<?php

namespace app\modules\bonus\widgets\BonusFiled;


use app\modules\bonus\models\entity\UserBonus;
use app\modules\site\models\tools\Debug;
use yii\bootstrap\Widget;
use yii\helpers\Html;

class BonusFieldWidget extends Widget
{

    public $model;
    public $attribute;
    private $bonusAccount;

    public function init()
    {
        if (!\Yii::$app->user->isGuest) {
            $this->bonusAccount = UserBonus::findByPhone(\Yii::$app->user->identity->phone);
        }
    }

    public function run()
    {
        if ($this->bonusAccount instanceof UserBonus) {
            echo Html::activeInput('text', $this->model, $this->attribute, [
                'class' => 'checkout-form__input js-validate-promocode',
                'placeholder' => 'Списать бонусы'
            ]);
            echo Html::input('range', 'bonus', null, [
                'class' => 'js-select-user-bonus',
                'id' => 'js-bonus-input',
                'data-min' => 0,
                'data-from' => $this->bonusAccount->count > 0 ? 1 : 0,
                'data-max' => $this->bonusAccount->count,
            ]);
        } else {
            echo Html::tag('div', Html::tag('div', 'Чтобы воспользоваться бонусами авторизуйтесь на сайте') . Html::tag('button', 'Войти на сайт', [
                    'class' => 'checkout-button-auth',
                    'type' => 'button',
                    'data-toggle' => 'modal',
                    'data-target' => '#signinModal'
                ]), ['class' => 'bonus-no-authorize']);
        }
    }
}