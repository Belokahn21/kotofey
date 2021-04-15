<?php


namespace app\modules\instagram\console;


use app\modules\logger\models\entity\Logger;
use app\modules\logger\models\search\LoggerSearchForm;
use app\modules\logger\models\service\LogService;
use app\modules\site\models\entity\ModuleSettings;
use app\modules\site\models\helpers\ModuleSettingsHelper;
use app\modules\site\Module;
use Bitrix\Location\Infrastructure\Service\LoggerService;
use yii\console\Controller;
use yii\helpers\Json;

class InstagramTokenController extends Controller
{
    public function actionRebase()
    {
        /* @var $module Module */
        $module = \Yii::$app->getModule('instagram');

        if (!$module) throw new \Exception('Модуль instagram не подключен.');

        $out = null;
        $params = [
            'grant_type' => 'ig_refresh_token',
            'access_token' => $module->instagram_token
        ];
        if ($curl = curl_init()) {
            curl_setopt($curl, CURLOPT_URL, 'https://graph.instagram.com/refresh_access_token?' . http_build_query($params));
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

            $out = curl_exec($curl);
            curl_close($curl);
        }
        $data = Json::decode($out);

        if (array_key_exists('access_token', $data)) {
            ModuleSettingsHelper::updateByParam('instagram_token', $data['access_token']);
            LogService::saveSuccessMessage('Токен виджета инстаграмма успешно обновлён', 'instagram_token');
        } else {
            if (array_key_exists('error', $data)) {
                LogService::saveErrorMessage('Ошибка обновления токена. Требуется ручное обновление токена в Facebook Dev кабинете Сообщение скрипта: ' . $data['error']['message'], 'instagram_token');
            }
        }
    }
}