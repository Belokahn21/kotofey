<?php

namespace app\models\entity;

use Yii;
use yii\behaviors\SluggableBehavior;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "vendor".
 *
 * @property int $id
 * @property int $is_active
 * @property int $sort
 * @property string $name
 * @property string $slug
 * @property string $address
 * @property int $group_id
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
            [['is_active', 'sort', 'group_id', 'created_at', 'updated_at'], 'integer'],
            [['name'], 'required'],
            [['name', 'slug', 'address'], 'string', 'max' => 255],
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
            'slug' => 'Символьный код',
            'address' => 'Адрес',
            'group_id' => 'Группа',
            'created_at' => 'Дата создания',
            'updated_at' => 'Дата опоздания',
        ];
    }
}
