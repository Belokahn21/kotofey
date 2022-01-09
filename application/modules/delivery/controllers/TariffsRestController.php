<?php


namespace app\modules\delivery\controllers;

use app\modules\catalog\models\helpers\PropertiesHelper;
use app\modules\catalog\models\repository\ProductRepository;
use app\modules\site\models\tools\Converter;
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
    public $name;
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
        if (!$product = ProductRepository::getOne($product_id)) throw new \Exception('Такого товара не существует.');

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
                    'width' => PropertiesHelper::extractPropertyById($product, 16)->value,
                    'height' => PropertiesHelper::extractPropertyById($product, 17)->value,
                    'length' => PropertiesHelper::extractPropertyById($product, 18)->value,
                    'weight' => round(floatval(PropertiesHelper::extractPropertyById($product, 2)->value) / 1000),
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
        if (!$product = ProductRepository::getOne($product_id)) throw new \Exception('Такого товара не существует.');


        $mass = floatval(PropertiesHelper::extractPropertyById($product, 2)->value);
        if ($mass < 1) $mass = $mass * 1000;
        else $mass = round($mass / 1000);

        $response = $this->getApi()->tariff($from, $to, array(
            'index-from' => $from,
            'index-to' => $to,
            'declared-value' => 0,
            'courier' => false,
            'mass' => $mass,
            'mail-type' => 'ONLINE_PARCEL',
            'mail-category' => 'ORDINARY',
            'fragile' => false,
            'inventory' => false,
            'dimension' => [
                'width' => PropertiesHelper::extractPropertyById($product, 16)->value,
                'height' => PropertiesHelper::extractPropertyById($product, 17)->value,
                'length' => PropertiesHelper::extractPropertyById($product, 18)->value,
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

            $token = "eyJhbGciOiJSUzI1NiIsInR5cCI6IkpXVCJ9.eyJzY29wZSI6WyJvcmRlcjphbGwiLCJwYXltZW50OmFsbCJdLCJleHAiOjE2NDE3NDAyMTksImF1dGhvcml0aWVzIjpbInNoYXJkLWlkOnJ1LTAxIiwiZnVsbC1uYW1lOtCi0LXRgdGC0LjRgNC-0LLQsNC90LjQtSDQmNC90YLQtdCz0YDQsNGG0LjQuCDQmNCcLCDQntCR0KnQldCh0KLQktCeINChINCe0JPQoNCQ0J3QmNCn0JXQndCd0J7QmSDQntCi0JLQldCi0KHQotCS0JXQndCd0J7QodCi0KzQriIsImFjY291bnQtbGFuZzpydXMiLCJjb250cmFjdDrQmNCcLdCg0KQt0JPQm9CTLTIyIiwiYXBpLXZlcnNpb246MS4xIiwiYWNjb3VudC11dWlkOmU5MjViZDBmLTA1YTYtNGM1Ni1iNzM3LTRiOTljMTRmNjY5YSIsImNsaWVudC1pZC1lYzU6ZWQ3NWVjZjQtMzBlZC00MTUzLWFmZTktZWI4MGJiNTEyZjIyIiwiY2xpZW50LWlkLWVjNDoxNDM0ODIzMSIsImNvbnRyYWdlbnQtdXVpZDplZDc1ZWNmNC0zMGVkLTQxNTMtYWZlOS1lYjgwYmI1MTJmMjIiLCJzb2xpZC1hZGRyZXNzOmZhbHNlIiwiY2xpZW50LWNpdHk60J3QvtCy0L7RgdC40LHQuNGA0YHQuiwg0J3QvtCy0L7RgdC40LHQuNGA0YHQutCw0Y8g0L7QsdC7LiJdLCJqdGkiOiI3Mzc1OWMyYi1mNmQ5LTRkMGUtYjE5NS1mYmUxMjI2MTVlYjgiLCJjbGllbnRfaWQiOiJFTXNjZDZyOUpuRmlRM2JMb3lqSlk2ZU03OEpySmNlSSJ9.Q_ucsF44D-hFyUHYXM8ivG8fo4KpyFsmdEU0MeWo4ohr-b_YdVOUTAnaAbG8MvEYN5Pt1gWuCGklb4uU8hE7cQHH-1gIIEXIjEZ85Mwt1lFozHgZV905Xy_GJdctqnPEQ7rjGmZ9EThH14HMJkMHxpxFN7_Lqp-tof5MexLJ3WZPGgd4_9txhLY-s3xU3HLntJ9qXGKW8o8ZDZGIezqmrxLWZB9EsyonmncFhkt_PqT4Tj7MOPDGDFj0v16xdS0Bg_CWz2FE1B4zYHRuXlE1t9hMqEbK_nD_1Cb8xVFmPKCtVVX88atxWe9nX3CRGeivjmSwu7RaeASIj2Xns1ze-w";
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
        $this->name = 'Доставка Сдек до терминала';
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
        $this->name = 'Доставка Почта России';
        $this->min_day = ArrayHelper::getValue($response, 'delivery-time.min-days');
        $this->max_day = ArrayHelper::getValue($response, 'delivery-time.max-days');
        $this->total_sum = Converter::pennyToRub(ArrayHelper::getValue($response, 'total-rate'), true);
        return $this;
    }
}