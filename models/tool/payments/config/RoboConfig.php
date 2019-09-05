<?

namespace app\models\tool\payments\config;


class RoboConfig
{
    public static function getConfig($isTest = true)
    {
        if ($isTest === true) {
            return new TestRoboConfig("eventhorizont", "J02yLbKrfNPxW7fbHb44", "Оплата товара", $isTest);
        } else {
            return new MainRoboConfig("eventhorizont", "poNFiIQGb287l4ASx1mz", "Оплата товара", $isTest);
        }
    }
}