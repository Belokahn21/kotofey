<?php

namespace app\modules\site\models\forms;


use yii\base\Model;

class GrumingForm extends Model
{
    public $phone;
    public $service;
    public $pet;
    public $date;
    public $client;

    public function rules()
    {
        return [
            [['pet', 'service', 'date', 'phone', 'client'], 'string'],
            [['date', 'phone', 'pet', 'service', 'client'], 'required', 'message' => 'Поле {attribute} нужно обязательно заполнить']
        ];
    }

    public function getPets()
    {
        return [
            'Кошка' => 'Кошка',
            'Собака' => 'Собака'
        ];
    }

    public function getServices()
    {
        return [
            'Мойка' => 'Мойка',
            'Линька' => 'Линька',
            'Супер-линька' => 'Супер-линька',
            'Стрижка' => 'Стрижка'
        ];
    }

    public function attributeLabels()
    {
        return [
            'pet' => 'Питомец',
            'date' => 'Дата посещения',
            'service' => 'Услуга',
            'phone' => 'Телефон',
            'client' => 'ФИО',
        ];
    }
}