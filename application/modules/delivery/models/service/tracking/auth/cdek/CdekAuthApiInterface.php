<?php


namespace app\modules\delivery\models\service\tracking\auth\cdek;

/**
 * Interface CdekAuthApiInterface
 * @package app\modules\delivery\models\service\tracking\auth\cdek
 *
 * @property $access_token
 * @property $token_type
 * @property $expires_in
 * @property $scope
 * @property $jti
 */
interface CdekAuthApiInterface
{
    public function __construct(string $login, string $password);
}