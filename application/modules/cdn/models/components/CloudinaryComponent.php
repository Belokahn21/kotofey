<?php


namespace app\modules\cdn\models\components;


use Cloudinary\Api;

class CloudinaryComponent
{
    private $_cdn;

    public function __construct()
    {
        \Cloudinary::config([
            "cloud_name" => "kotofey-store",
            "api_key" => "313768283447262",
            "api_secret" => "Wm28QI4nQIolSV1J7Hd0hArxuzM",
            "secure" => true
        ]);

        $this->_cdn = new Api();
    }

    public static function getInstance()
    {
        return new CloudinaryComponent();
    }

    public function getAllResources($options = [])
    {
        return $this->_cdn->resources($options);
    }

    public function removeResource($public_id)
    {
        return $this->_cdn->delete_resources($public_id);
    }
}