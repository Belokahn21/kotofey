<?php

namespace app\modules\acquiring\models\services\ofd\models;

use app\modules\acquiring\Module;

/**
 * @property string $ofd_token
 * @property Module $module
 */
class OFDApiProduction extends OFDApi
{
    protected $_url = 'https://ferma.ofd.ru/api/kkt/cloud/';
}