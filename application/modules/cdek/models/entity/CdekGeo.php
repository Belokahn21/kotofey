<?php

namespace app\modules\cdek\models\entity;

use Yii;

/**
 * This is the model class for table "cdek_geo".
 *
 * @property int $id
 * @property int|null $city_id
 * @property int|null $postcode
 * @property string|null $FullName
 * @property string|null $CityName
 * @property string|null $FIAS
 * @property string|null $KLADR
 * @property string|null $pvzCode
 */
class CdekGeo extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'cdek_geo';
    }

    public function rules()
    {
        return [
            [['city_id'], 'integer'],
            [['FIAS', 'KLADR', 'postcode'], 'string'],
            [['FullName', 'CityName', 'pvzCode'], 'string', 'max' => 255],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'city_id' => 'ID города(сдек)',
            'postcode' => 'Почтовый индекс',
            'FullName' => 'Полное наименование',
            'CityName' => 'Город',
            'FIAS' => 'ФИАС',
            'KLADR' => 'КЛАДР',
            'pvzCode' => 'ПВЗ код',
        ];
    }
}
