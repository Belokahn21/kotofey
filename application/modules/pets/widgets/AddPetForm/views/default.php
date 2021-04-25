<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\modules\pets\models\entity\Animal;
use app\modules\pets\models\helpers\PetsHelper;

/* @var $petModel \app\modules\pets\models\entity\Pets
 * @var $animals \app\modules\pets\models\entity\Animal[]
 * @var $this \yii\web\View
 * @var $action string
 */


?>
<div class="authModal modal fade" id="newPetModal" tabindex="-1" role="dialog" aria-labelledby="newPetModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="site-form">
                <div class="modal-header">
                    <div class="div">
                        <h5 class="modal-title" id="newPetModalLabel">Карточка нового питомца</h5>
                    </div>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                </div>
                <?php $form = ActiveForm::begin([
                    'action' => $action
                ]); ?>
                <div class="modal-body">
                    <div class="site-form__item">
                        <div class="select-pet">
                            <?= $form->field($petModel, 'animal_id')->radioList(ArrayHelper::map($animals, 'id', 'name'), [
                                'item' => function ($index, $label, $name, $checked, $value) {
                                    $animal = Animal::findOne($value);
                                    return <<<LIST
                                        <div class="select-pet__item">
                                            <input type="radio" name="$name" value="$value" id="select-pet-dog-$value">
                                            <label class="select-pet__icon" for="select-pet-dog-$value"><i class="$animal->icon"></i></label>
                                        </div>
LIST;
                                }
                            ])->label('Выберите кто ваш питомец') ?>
                        </div>
                    </div>
                    <div class="site-form__group-row">
                        <div class="site-form__side">

                            <div class="site-form__item">
                                <label class="site-form__label" for="site-form-pet-name">Кличка питомца</label>
                                <?= $form->field($petModel, 'name')->textInput([
                                    'class' => 'site-form__input',
                                    'id' => 'site-form-pet-name',
                                    'placeholder' => 'Кличка питомца',
                                ])->label(false); ?>
                            </div>

                            <div class="site-form__item">
                                <label class="site-form__label" for="site-form-pet-birthday">День рождения питомца</label>
                                <?= $form->field($petModel, 'birthday')->textInput([
                                    'class' => 'site-form__input js-datepicker',
                                    'id' => 'site-form-pet-birthday',
                                    'placeholder' => 'День рождения питомца',
                                ])->label(false); ?>
                            </div>

                            <div class="site-form__item">
                                <label class="site-form__label" for="site-form-pet-sex">Пол вашег питомца</label>
                                <?= $form->field($petModel, 'sex_id')->dropDownList($petModel->getSexes(), [
                                    'class' => 'site-form__input',
                                    'id' => 'site-form-pet-sex',
                                    'prompt' => 'Пол вашего питомца',
                                ])->label(false); ?>
                            </div>
                        </div>
                        <div class="site-form__side">


                            <div class="site-form__item">
                                <label class="site-form__label noUpload" for="site-form-pet-avatar"></label>
                                <?= $form->field($petModel, 'avatar')->fileInput([
                                    'class' => 'site-form__input',
                                    'id' => 'site-form-pet-avatar',
                                    'prompt' => 'Пол вашего питомца',
                                ])->label(false); ?>
                            </div>
                            <p class="select-pet__note">Загрузить фото питомца</p>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <?= Html::submitButton('Добавить', ['class' => 'site-form__button']); ?>
                    </div>

                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="profile__inline-group">
    <h2 class="page__title">Ваши питомцы</h2>
    <?php if (!PetsHelper::isOverLimit(Yii::$app->user->id)): ?>
        <button class="profile-pet__add" type="button" data-toggle="modal" data-target="#newPetModal">Добавить</button>
    <?php endif ?>
</div>