<?

namespace app\models\tool\payments\config;


class TestRoboConfig extends AbstractRoboConfig
{
    public function __construct($login, $password, $description, $isTest)
    {
        $this->setLogin($login);
        $this->setPassword($password);
        $this->setDescription($description);
        $this->setIsTest($isTest);
    }
}