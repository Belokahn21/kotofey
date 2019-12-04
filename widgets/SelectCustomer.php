<?php
/**
 * Developer: Konstantin Vasin by PhpStorm
 * Company: Altasib
 * Time: 2:55
 */

namespace app\widgets;

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use app\models\entity\User;

class SelectCustomer extends \yii\base\Widget
{
    public $model, $attribute;

    public function run()
    {
        echo Html::beginTag('div', ['class' => 'left-col']);
        echo Html::tag('h3', 'Выбрать из списка', ['class' => 'title']);
        echo Html::activeDropDownList($this->model, $this->attribute, ArrayHelper::map(User::find()->all(), 'id', 'name'), ['size' => '13', 'class' => 'block-item select-order-user']);
        echo Html::endTag('div');

        echo Html::beginTag('div', ['class' => 'left-col new-customer-order']);
        echo Html::tag('h3', 'Новый пользователь', ['class' => 'title']);

        echo Html::label('E-Mail');
        echo Html::activeInput('text', $this->model, 'email', ['class' => 'block-item']);

        echo Html::label('Пароль');
        echo Html::activeInput('password', $this->model, 'new_password', ['class' => 'block-item']);

        echo Html::label('Фамилия');
        echo Html::activeInput('text', $this->model, 'first_name', ['class' => 'block-item']);

        echo Html::label('Имя');
        echo Html::activeInput('text', $this->model, 'name', ['class' => 'block-item']);

        echo Html::label('Отчество');
        echo Html::activeInput('text', $this->model, 'last_name', ['class' => 'block-item']);
        echo Html::endTag('div');
        return;
    }
}