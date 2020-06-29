<?php

namespace app\modules\catalog\models\entity;


use yii\behaviors\SluggableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * ProductProperties model
 *
 * @property integer $id
 * @property integer $active
 * @property boolean $multiple
 * @property integer $need_show
 * @property integer $sort
 * @property integer $type
 * @property integer $informer_id
 * @property string $name
 * @property string $slug
 * @property integer $created_at
 * @property integer $updated_at
 */
class ProductProperties extends ActiveRecord
{
    public static function tableName()
    {
        return "product_properties";
    }

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

    public function rules()
    {
        return [
            ['name', 'required', 'message' => 'Поле {attribute} должно быть заполнено'],

            [['active','need_show', 'sort', 'type', 'informer_id'], 'integer'],

            [['multiple'], 'boolean'],

            [['active'], 'default', 'value' => 1],

            [['need_show'], 'default', 'value' => 1],

            [['multiple'], 'default', 'value' => false],

            [['sort'], 'default', 'value' => 500],
        ];
    }

    public function attributeLabels()
    {
        return [
            'name' => 'Название',
            'active' => 'Активность',
            'need_show' => 'Выводить на сайте',
            'sort' => 'Сортировка',
            'type' => 'Тип',
            'multiple' => 'Множественный выбор',
            'informer_id' => 'ID справочника',
        ];
    }
}