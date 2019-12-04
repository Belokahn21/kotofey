<?php

namespace app\models\entity;


use yii\data\ActiveDataProvider;
use yii\db\ActiveRecord;

class OrderStatus extends ActiveRecord
{
    public static function tableName()
    {
        return "status_order";
    }

    public function rules()
    {
        return [
            ['name', 'string'],
            ['name', 'required', 'message' => '{attribute} должно быть заполнено'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'name' => "Название"
        ];
    }

	public function search($params)
	{
		$query = static::find();

		$dataProvider = new ActiveDataProvider([
			'query' => $query,
		]);

		if (!($this->load($params) && $this->validate())) {
			return $dataProvider;
		}

		$query->andFilterWhere(['like', 'name', $this->name]);

		return $dataProvider;
	}
}