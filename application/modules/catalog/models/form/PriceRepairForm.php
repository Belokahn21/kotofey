<?php


namespace app\modules\catalog\models\form;


use app\modules\catalog\models\entity\Offers;
use app\modules\site_settings\models\helpers\MarkupHelpers;
use app\modules\site\models\tools\Debug;
use yii\base\Model;

class PriceRepairForm extends Model
{
    public $name;
    public $amount;

    public function rules()
    {
        return [
            [['name', 'amount'], 'required'],
            [['name'], 'string'],
            [['amount'], 'integer'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'name' => 'Название',
            'amount' => 'Количество',
        ];
    }

    public function run()
    {
        $models = Offers::find();

        foreach (explode(' ', $this->name) as $text_line) {
            $models->andFilterWhere([
                'or',
                ['like', 'name', $text_line],
                ['like', 'feed', $text_line]
            ]);
        }

        $models = $models->all();

        foreach ($models as $model) {
            $model->scenario = Offers::SCENARIO_UPDATE_PRODUCT;
            MarkupHelpers::applyMarkup($model, $this->amount);

            if (!$model->validate() || !$model->update()) {
                continue;
            }
        }

        return true;
    }
}