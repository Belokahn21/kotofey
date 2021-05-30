<?php


namespace app\modules\search\models\services\SearchHistory;


use yii\web\Cookie;

class SearchHistoryStorage
{
    const SEARCH_HISTORY_KEY = 'search_history';
    private $write_cookie;
    private $read_cookie;

    public function __construct()
    {
        $this->write_cookie = \Yii::$app->response->cookies;
        $this->read_cookie = \Yii::$app->request->cookies;
    }

    public function save(array $data)
    {
        $this->write_cookie->add(new Cookie([
            'name' => self::SEARCH_HISTORY_KEY,
            'value' => $data
        ]));
    }

    public function get()
    {
        return array_unique($this->read_cookie->getValue(self::SEARCH_HISTORY_KEY, []));
    }
}