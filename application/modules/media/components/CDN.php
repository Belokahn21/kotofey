<?php

namespace app\modules\media\components;


use yii\base\Component;

class CDN extends Component
{
    public $cloud_name;
    public $api_key;
    public $api_secret;
    public $secure;

    public function init()
    {
        \Cloudinary::config(array(
            "cloud_name" => $this->cloud_name,
            "api_key" => $this->api_key,
            "api_secret" => $this->api_secret,
            "secure" => $this->secure
        ));
    }

    public function uploadImage($path)
    {

        return \Cloudinary\Uploader::upload($path);
    }

    public function resizeImageTag($public_id, $options = [])
    {

        return cl_image_tag($public_id, $options);
    }

    public function resizeImage($public_id, $options = [])
    {
        return \Cloudinary::cloudinary_url($public_id, $options);
    }
}