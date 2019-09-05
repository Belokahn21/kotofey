<?

namespace app\widgets\order_custom_product\models;

use app\models\tool\vk\VKMethods;
use yii\base\Model;

class OrderCustomProductForm extends Model
{
    public $type;
    public $leather_type;
    public $description;
    public $color;
    public $phone;
    public $email;

    public function rules()
    {
        return [
            [['email', 'phone'], 'required', 'message' => 'Поле {attribute} нужно заполнить'],

            [['email'], 'email', 'message' => 'Некоректное значение поля {attribute}'],

            [['type', 'leather_type', 'description', 'color', 'email', 'phone'], 'string'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'type' => "Предмет",
            'leather_type' => "Тип кожи",
            'description' => "Описание",
            'color' => "Цвет",
            'email' => "Электронная почта",
            'phone' => "Телефон",
        ];
    }

    public function save()
    {

        if (!empty($this->description)) {
            $message = "Заказ на собственный товар. Контакты: " . $this->email . " телефон: " . $this->phone . ". О заказе: " . $this->description;
        } else {
            $message = "Заказ на собственный товар. Контакты: " . $this->email . " телефон: " . $this->phone . ".\nО заказе: \nПредмет: " . $this->type . "\nКожа:" . $this->leather_type . "\nЦвет:" . $this->color;
        }
        (new VKMethods())->sendUserMessage("111815168", $message);

        \Yii::$app->mailer->compose('adminNotifyAboutCustomProduct', [
            'email' => $this->email,
            'phone' => $this->phone,
            'description' => $this->description,
            'type' => $this->type,
            'color' => $this->color,
            'leather' => $this->leather_type,
        ])
            ->setFrom(\Yii::$app->params['email']['infoEmail'])
            ->setTo(\Yii::$app->params['email']['mainEmail'])
            ->setSubject('Заказ на ручную работу на eventhorizont.ru')
            ->send();


        return true;
    }
}