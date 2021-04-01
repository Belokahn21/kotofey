<?php

namespace app\modules\site\models\entity;

use Yii;

/**
 * This is the model class for table "module_settings".
 *
 * @property int $id
 * @property string|null $module_id
 * @property string|null $param_name
 * @property string|null $param_value
 * @property int|null $created_at
 * @property int|null $updated_at
 */
class ModuleSettings extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'module_settings';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['created_at', 'updated_at'], 'integer'],
            [['module_id', 'param_name', 'param_value'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'module_id' => 'Module ID',
            'param_name' => 'Param Name',
            'param_value' => 'Param Value',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
