<?php


namespace app\modules\delivery\models\service\delivery\tariffs;


class TariffDataBuild
{
    private $_data;

    public function __construct(array $post_data)
    {
        $this->_data = $post_data;
    }

    public static function getInstance(array $post_data)
    {
        return new TariffDataBuild($post_data);
    }

    public function getTariff()
    {
        switch ($this->_data['service']) {
            case "ru_post":
                return new RuPostTariffData($this->_data);
            default:
                throw new \Exception('Не передана информация о сервисе.');
        }
    }
}