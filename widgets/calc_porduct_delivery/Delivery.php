<?

namespace app\widgets\calc_porduct_delivery;


use yii\base\Widget;

class Delivery extends Widget
{
    public function run()
    {
        return $this->render('default');
    }

    public function init()
    {
        parent::init();
    }
}