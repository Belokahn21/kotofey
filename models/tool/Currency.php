<?

namespace app\models\tool;


class Currency
{
    public $currentCurrency;

    public static function getInstance()
    {
        return new Currency();
    }

    public function __construct()
    {
        $this->currentCurrency = '<i style="font-size: 80%;" class="fas fa-ruble-sign"></i>';
    }

    public function show()
    {
        return $this->currentCurrency;
    }
}