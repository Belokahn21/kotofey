<?

namespace app\widgets\promoCart;

use app\models\entity\Basket;
use app\models\entity\Promo;
use app\models\tool\Debug;
use app\widgets\promoCart\models\form\PromoCartForm;
use yii\base\Widget;

class promoCartWidget extends Widget
{
    public function run()
    {
        $model = new PromoCartForm();
        $basket = new Basket();
        $promo = $basket->getPromo();

        if (\Yii::$app->request->isPjax) {

            if ($model->load(\Yii::$app->request->post())) {

                if ($model->validate()) {

                    $promo = Promo::findByCode($model->code);

                    if ($promo && $promo->count > 0) {

                        $basket->addPromo($promo);
                        return $this->render('promo', [
                            'promo' => $promo
                        ]);

                    }
                }

            }

        }

        return $this->render('promo', [
            'model' => $model,
            'promo' => $promo
        ]);
    }

    public function init()
    {
        parent::init();
    }
}