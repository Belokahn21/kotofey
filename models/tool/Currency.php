<?
/**
 * Developer: Konstantin Vasin by PhpStorm
 * Company: Altasib
 * Time: 14:09
 */

namespace app\models\tool;


class Currency
{
    public $currentCurrency;

    public function __construct()
    {
//        $this->currentCurrency = "р.";
        $this->currentCurrency = '<i style="font-size: 80%;" class="fas fa-ruble-sign"></i>';
    }

    public function show()
    {
        return $this->currentCurrency;
    }
}