<?php

use VK\Client\VKApiClient;

$model=\app\models\entity\Product::findOne(1);
$group_id = 185683081;
$access_token = '9a59bee577bfac9297aaab387a5d22ca36b847e5b414823b33f7c53f0e214d4ee828f1e8755004c99c515';
$vk = new VKApiClient();

$response = $vk->photos()->getMarketUploadServer($access_token, [
    'group_id' => $group_id,
    'main_photo' => 1,
]);
if ($curl = curl_init()) {

//						$filename = str_replace('/', "\\", \Yii::getAlias('@webroot/upload/' . $model->image));
    $filename = \Yii::getAlias('@webroot/upload/' . $model->image);
    $finfo = new \finfo(FILEINFO_MIME_TYPE);
    $mimetype = $finfo->file($filename);


    curl_setopt($curl, CURLOPT_URL, $response['upload_url']);
    curl_setopt($curl, CURLOPT_HTTPHEADER, array("Content-type: multipart/form-data"));
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, [
        'file' => curl_file_create($filename, $mimetype, basename($filename))
    ]);
    $out = curl_exec($curl);
    $obj = \yii\helpers\Json::decode($out);
    curl_close($curl);

}

\app\models\tool\Debug::p($obj);