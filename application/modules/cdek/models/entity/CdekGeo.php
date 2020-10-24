<?php

namespace app\modules\cdek\models\entity;

use Yii;

/**
 * This is the model class for table "cdek_geo".
 *
 * @property int $id
 * @property int|null $city_id
 * @property string|null $FullName
 * @property string|null $CityName
 * @property string|null $FIAS
 * @property string|null $KLADR
 * @property string|null $pvzCode
 */
class CdekGeo extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'cdek_geo';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['city_id'], 'integer'],
            [['FIAS', 'KLADR'], 'string'],
            [['FullName', 'CityName', 'pvzCode'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'city_id' => 'City ID',
            'FullName' => 'Full Name',
            'CityName' => 'City Name',
            'FIAS' => 'Fias',
            'KLADR' => 'Kladr',
            'pvzCode' => 'Pvz Code',
        ];
    }
}
