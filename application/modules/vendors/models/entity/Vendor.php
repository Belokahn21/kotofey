<?php

namespace app\modules\vendors\models\entity;

use Yii;
use yii\behaviors\SluggableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\helpers\Json;

/**
 * This is the model class for table "vendor".
 *
 * @property int $id
 * @property int $is_active
 * @property int $sort
 * @property string $name
 * @property string $slug
 * @property string $address
 * @property string $delivery_days
 * @property string $email
 * @property string $phone
 * @property int $group_id
 * @property int $discount
 * @property int $min_summary_sale
 * @property int $time_open
 * @property int $time_close
 * @property int $created_at
 * @property int $updated_at
 */
class Vendor extends \yii\db\ActiveRecord
{

    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
            [
                'class' => SluggableBehavior::className(),
                'attribute' => 'name',
                'ensureUnique' => true,
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'vendor';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['is_active', 'sort', 'group_id', 'created_at', 'updated_at', 'discount', 'time_open', 'time_close', 'min_summary_sale', 'phone'], 'integer'],
            [['name'], 'required'],
            [['name', 'slug', 'address', 'legal_name'], 'string', 'max' => 255],
            [['email'], 'string'],
            [['delivery_days'], 'safe'],
            [['email'], 'email'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'is_active' => 'Активность',
            'sort' => 'Сортировка',
            'name' => 'Название',
            'email' => 'Контактный E-Mail',
            'phone' => 'Контактный телефон',
            'delivery_days' => 'В какие дни отгрузка',
            'legal_name' => 'Юридическое название',
            'slug' => 'Символьный код',
            'address' => 'Адрес',
            'group_id' => 'Группа',
            'discount' => 'Скидка',
            'min_summary_sale' => 'Минимальная сумма заказа',
            'time_open' => 'Время открытия',
            'time_close' => 'Время закрытия',
            'created_at' => 'Дата создания',
            'updated_at' => 'Дата опоздания',
        ];
    }

    public function afterFind()
    {
        $this->delivery_days = Json::decode($this->delivery_days);
        parent::afterFind();
    }

    public function beforeValidate()
    {
        $this->delivery_days = Json::encode($this->delivery_days);
        return parent::beforeValidate();
    }
}
