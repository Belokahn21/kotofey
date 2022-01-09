<?php


namespace app\modules\delivery\controllers;

use app\modules\site\models\tools\Debug;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\rest\Controller;


class TariffsRestController extends Controller
{
    public function actionCreate()
    {
        $post_data = \Yii::$app->request->post();

        $rupost_service = new rupost_service();
        $cdek_service = new cdek_service();

        Debug::p($rupost_service->tariff(656000, 443082, 1));
        Debug::p($cdek_service->tariff(656000, 443082, 1));
    }
}

interface delivery_api_interface
{
    public function execute(string $url, array $params);

    public function tariff(string $from, string $to, array $params);
}

interface delivery_service_interface
{
    public function tariff();

    public function tariffs();
}

interface delivery_response_normalize_interface
{
    public function response(array $response);
}

/**
 * @var $api delivery_api_interface
 * @var $normalizer delivery_response_normalize_interface
 */
abstract class delivery_serivce
{
    private $api;
    private $normalizer;

    /**
     * @param delivery_api_interface $api
     */
    public function setApi(delivery_api_interface $api): void
    {
        $this->api = $api;
    }

    /**
     * @return delivery_api_interface
     */
    public function getApi()
    {
        return $this->api;
    }

    /**
     * @param delivery_response_normalize_interface $normalizer
     */
    public function setNormalizer(delivery_response_normalize_interface $normalizer): void
    {
        $this->normalizer = $normalizer;
    }

    /**
     * @return delivery_response_normalize_interface
     */
    public function getNormalizer()
    {
        return $this->normalizer;
    }
}

abstract class delivery_response implements delivery_response_normalize_interface
{
    public $min_day;
    public $max_day;
    public $total_sum;

    public function response(array $response)
    {
    }
}

class cdek_service extends delivery_serivce
{
    public function __construct()
    {
        $this->setApi(new cdek_api());
        $this->setNormalizer(new cdek_response_normalize());
    }

    public function tariff(string $from, string $to, int $product_id)
    {
        $response = $this->getApi()->tariff($from, $to, array(
            "type" => 1,
            "date" => date('Y-m-d\Th:i:s+0700'),
            "currency" => 1,
            'tariff_code' => '136',
            "lang" => "rus",
            'from_location' => [
                'postal_code' => $from,
            ],
            'to_location' => [
                'postal_code' => $to,
            ],
            'packages' => [
                [
                    'width' => 20,
                    'height' => 20,
                    'length' => 20,
                    'weight' => 5000,
                ]
            ],

        ));

        return $this->getNormalizer()->response($response);
    }

}

class rupost_service extends delivery_serivce
{
    public function __construct()
    {
        $this->setApi(new rupost_api());
        $this->setNormalizer(new rupost_response_normalize());
    }

    public function tariff(string $from, string $to, int $product_id)
    {
        $response = $this->getApi()->tariff($from, $to, array(
            'index-from' => $from,
            'index-to' => $to,
            'declared-value' => 0,
            'courier' => false,
            'mass' => 5000,
            'mail-type' => 'ONLINE_PARCEL',
            'mail-category' => 'ORDINARY',
            'fragile' => false,
            'inventory' => false,
            'dimension' => [
                'height' => 20,
                'length' => 20,
                'width' => 20,
            ]
        ));

        return $this->getNormalizer()->response($response);
    }
}

class rupost_api implements delivery_api_interface
{

    public function tariff(string $from, string $to, array $params)
    {
        return $this->execute('/1.0/tariff', $params);
    }


    public function execute(string $url, array $params)
    {
        $headers = [];
        $response = false;
        if ($curl = curl_init()) {
            $headers[] = "Authorization: AccessToken 0t_jz_hNllKIgH5Z_Rc7z1cHI2RiMmqx";
            $headers[] = "X-User-Authorization: Basic aW5mb0Brb3RvZmV5LnN0b3JlOjEyM3F3ZVIl";
            $headers[] = "Content-Type: application/json;charset=UTF-8";

            if ($headers) curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

            curl_setopt($curl, CURLOPT_URL, 'https://otpravka-api.pochta.ru' . $url);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_POST, true);
            curl_setopt($curl, CURLOPT_POSTFIELDS, Json::encode($params));
            $response = curl_exec($curl);
            curl_close($curl);
        }

        return Json::decode($response);
    }
}

class cdek_api implements delivery_api_interface
{

    public function tariff(string $from, string $to, array $params)
    {
        return $this->execute('https://api.edu.cdek.ru/v2/calculator/tariff', $params);
    }

    public function execute(string $url, array $params)
    {
        $response = false;
        $headers = [];
        if ($curl = curl_init()) {

            $token = "eyJhbGciOiJSUzI1NiIsInR5cCI6IkpXVCJ9.eyJzY29wZSI6WyJvcmRlcjphbGwiLCJwYXltZW50OmFsbCJdLCJleHAiOjE2NDE3MzU3NzksImF1dGhvcml0aWVzIjpbInNoYXJkLWlkOnJ1LTAxIiwiZnVsbC1uYW1lOtCi0LXRgdGC0LjRgNC-0LLQsNC90LjQtSDQmNC90YLQtdCz0YDQsNGG0LjQuCDQmNCcLCDQntCR0KnQldCh0KLQktCeINChINCe0JPQoNCQ0J3QmNCn0JXQndCd0J7QmSDQntCi0JLQldCi0KHQotCS0JXQndCd0J7QodCi0KzQriIsImNvbnRyYWN0OtCY0Jwt0KDQpC3Qk9Cb0JMtMjIiLCJhY2NvdW50LWxhbmc6cnVzIiwiYXBpLXZlcnNpb246MS4xIiwiYWNjb3VudC11dWlkOmU5MjViZDBmLTA1YTYtNGM1Ni1iNzM3LTRiOTljMTRmNjY5YSIsImNsaWVudC1pZC1lYzU6ZWQ3NWVjZjQtMzBlZC00MTUzLWFmZTktZWI4MGJiNTEyZjIyIiwiY2xpZW50LWlkLWVjNDoxNDM0ODIzMSIsInNvbGlkLWFkZHJlc3M6ZmFsc2UiLCJjb250cmFnZW50LXV1aWQ6ZWQ3NWVjZjQtMzBlZC00MTUzLWFmZTktZWI4MGJiNTEyZjIyIiwiY2xpZW50LWNpdHk60J3QvtCy0L7RgdC40LHQuNGA0YHQuiwg0J3QvtCy0L7RgdC40LHQuNGA0YHQutCw0Y8g0L7QsdC7LiJdLCJqdGkiOiI5NzEwNWUxMy05M2I4LTQ0ZmUtOTQ2Ni0yNjYzNDI3Zjc1ZWYiLCJjbGllbnRfaWQiOiJFTXNjZDZyOUpuRmlRM2JMb3lqSlk2ZU03OEpySmNlSSJ9.kieW2gXWOayfUmi9vbcU_oGdnQtIsZETqoslurOHqbJ08uoWn7omDZjRaZCzugWHJWsGF6OvMVV3nsbbYTXf8FJ2DToTrmdyBKdvU46v-CW7POqTPE4hSaEWLgTwIc_SoqpQANYx7cnxF2KX2xa1tJMZ-jN4bZnSliG8q1GceDwmggRwfO9ivrj6mLZxgy3iA3zNzDo1HTlwFLRARdZDxqBsvsabPpmLC4htAd6qfQAJ1xEqyG_ObH6oo9fbu5Od_AOr992CvntqMMoxv48rGyUwXD1lE_8ap8ksPzU6lzpEne03RmzihCmSmJ8HJjFQmpXs7Z278x8txtIEZa3C_Q";
            $headers[] = "Authorization: Bearer {$token}";
            $headers[] = "Content-Type: application/json";

            if ($headers) curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_POST, true);
            curl_setopt($curl, CURLOPT_POSTFIELDS, Json::encode($params));
            $response = curl_exec($curl);
            curl_close($curl);
        }

        return Json::decode($response);
    }
}

class cdek_response_normalize extends delivery_response
{
    public function response(array $response)
    {
        $this->min_day = ArrayHelper::getValue($response, 'period_min');
        $this->max_day = ArrayHelper::getValue($response, 'period_max');
        $this->total_sum = ArrayHelper::getValue($response, 'total_sum');
        return $this;
    }
}

class rupost_response_normalize extends delivery_response
{
    public function response(array $response)
    {
        $this->min_day = ArrayHelper::getValue($response, 'delivery-time.min-days');
        $this->max_day = ArrayHelper::getValue($response, 'delivery-time.max-days');
        $this->total_sum = ArrayHelper::getValue($response, 'total-rate');
        return $this;
    }
}