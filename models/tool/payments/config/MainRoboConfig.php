<?

namespace app\models\tool\payments\config;


class MainRoboConfig extends AbstractRoboConfig
{
    public function __construct($login, $password, $description, $isTest)
    {
        $this->setLogin($login);
        $this->setPassword($password);
        $this->setDescription($description);
    }
}