<?

namespace app\models\tool\payments\config;


abstract class AbstractRoboConfig
{
    private $login;
    private $password;
    private $description;
    private $isTest;
    private $invID;
    private $sum;

    abstract public function __construct($login, $password, $description, $isTest);

    public function setDescription($description)
    {
        $this->description = $description;
    }

    public function setInvID($invID)
    {
        $this->invID = $invID;
    }

    public function setIsTest($isTest)
    {
        $this->isTest = $isTest;
    }

    public function setLogin($login)
    {
        $this->login = $login;
    }

    public function setPassword($password)
    {
        $this->password = $password;
    }

    public function setSum($sum)
    {
        $this->sum = $sum;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function getLogin()
    {
        return $this->login;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function getisTest()
    {
        return $this->isTest;
    }

    public function getInvID()
    {
        return $this->invID;
    }

    public function getSum()
    {
        return $this->sum;
    }
}