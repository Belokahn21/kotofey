<?php

namespace app\modules\bonus\widgets\BonusFiled;


use app\modules\bonus\models\entity\UserBonus;
use app\modules\bonus\models\helper\BonusHelper;
use app\modules\site\models\tools\Debug;
use yii\bootstrap\Widget;
use yii\helpers\Html;

class BonusFieldWidget extends Widget
{
    public $model;
    public $attribute;
    private $userBonus;

    public function init()
    {
        if (!\Yii::$app->user->isGuest) {
            $this->userBonus = BonusHelper::getUserBonus(\Yii::$app->user->identity->phone);
        }
    }

    public function run()
    {
        if (!\Yii::$app->user->isGuest) {

            echo Html::tag('div', Html::tag('div', 'Бонусы') . Html::tag('div', 'Доступно: ' . \Yii::t('app', '{n, plural, =0{# бонусов} =1{# бонус} one{# бонус} few{# бонусов} many{# бонусов} other{# бонуса}}', ['n' => $this->userBonus])), [
                'class' => 'checkout-form-label-group'
            ]);

            echo Html::activeInput('text', $this->model, $this->attribute, [
                'class' => 'checkout-form__input js-validate-promocode',
                'placeholder' => 'Списать бонусы'
            ]);
            echo Html::input('range', 'bonus', null, [
                'class' => 'js-select-user-bonus',
                'id' => 'js-bonus-input',
                'data-min' => 0,
                'data-from' => 0,
                'data-max' => $this->userBonus,
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