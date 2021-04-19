<?php


namespace app\modules\cdn\models\components;


use app\modules\site\models\tools\Debug;
use Cloudinary\Api\Admin\AdminApi;
use Cloudinary\Cloudinary;

class CloudinaryComponent
{
    private $_cdn;

    public function __construct()
    {
        $this->_cdn = new AdminApi([
            'cloud' => [
                "cloud_name" => "kotofey-store",
                "api_key" => "313768283447262",
                "api_secret" => "Wm28QI4nQIolSV1J7Hd0hArxuzM",
            ],
        ]);
    }

    public static function getInstance()
    {
        return new CloudinaryComponent();
    }

    public function getAllResources($options = [])
    {
        return $this->_cdn->assets($options);
    }
}