<?php

namespace app\modules\acquiring\models\services\ofd\models;

use app\modules\acquiring\Module;

/**
 * @property string $ofd_token
 * @property Module $module
 */
class OFDApi extends AbstractOFDApi
{
    const URL = 'https://ferma.ofd.ru/api/kkt/cloud/';
}