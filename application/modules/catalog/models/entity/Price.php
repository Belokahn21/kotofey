<?php

namespace app\modules\catalog\models\entity;

use app\modules\site\models\tools\Debug;
use Yii;
use yii\behaviors\SluggableBehavior;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "price".
 *
 * @property int $id
 * @property string|null $name
 * @property string $code
 * @property int|null $is_active
 * @property int|null $is_main
 * @property int|null $sort
 * @property int|null $created_at
 * @property int|null $updated_at
 */
class Price extends \yii\db\ActiveRecord
{
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
            [
                'class' => SluggableBehavior::className(),
                'attribute' => 'name',
                'slugAttribute' => 'code',
                'ensureUnique' => true,
                'immutable' => true
            ],
        ];
    }

    public function rules()
    {
        return [
            [['is_main'], 'default', 'value' => 0],
            ['is_main', function ($attribute, $params) {

                if ((int)$this->is_main == 1) {
                    if ($model = Price::findOne([$attribute => 1])) {

                        if ($model->id !== $this->id) {
                            $this->addError($attribute, 'Основная цена должна быть только одна!(Текущая: (id:' . $model->id . ') ' . $model->name . ')');
                        }
                    }
                }
            }],

            [['is_active'], 'default', 'value' => 1],

            [['sort'], 'default', 'value' => 500],

            [['is_active', 'is_main', 'sort', 'created_at', 'updated_at'], 'integer'],

            [['name', 'code'], 'string', 'max' => 255],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Название',
            'code' => 'Символьный код',
            'is_active' => 'Активность',
            'is_main' => 'Основаная цена',
            'sort' => 'Сортировка',
            'created_at' => 'Дата создания',
            'updated_at' => 'Дата обновления',
        ];
    }

    public static function findOneByCode(string $code)
    {
        return static::findOne(['code' => $code]);
    }
}
