<?

namespace app\models\tool\payments;


use app\models\tool\payments\config\RoboConfig;

class Robokassa extends AbstractRobokassa
{
    public function __construct()
    {
        $this->config = RoboConfig::getConfig(false);
    }
}