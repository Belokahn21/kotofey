<?php

namespace app\models\behaviors;


use app\models\entity\Product;
use app\models\entity\ProductMarket;
use app\models\tool\Debug;
use VK\Client\VKApiClient;
use VK\OAuth\Scopes\VKOAuthUserScope;
use VK\OAuth\VKOAuth;
use VK\OAuth\VKOAuthDisplay;
use VK\OAuth\VKOAuthResponseType;
use yii\base\Behavior;
use yii\db\BaseActiveRecord;
use yii\helpers\Json;

class SocialStore extends Behavior
{
    public $has_store;

    public function init()
    {
    }


    public function events()
    {
        return [
            BaseActiveRecord::EVENT_AFTER_INSERT => 'afterSave',
            BaseActiveRecord::EVENT_AFTER_UPDATE => 'afterSave',
        ];
    }

    public function afterSave()
    {
        /** @var Product $model */
        $model = $this->owner;
        Debug::printFile($model->image);
        $group_id = 185683081;
        if ((boolean)$model->{$this->has_store} === true) {

            if ($model->scenario == 'insert' && !empty($model->image) && strlen($model->description) > 10) {
                $access_token = '9a59bee577bfac9297aaab387a5d22ca36b847e5b414823b33f7c53f0e214d4ee828f1e8755004c99c515';
                $vk = new VKApiClient();
                if ($access_token) {
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

                    $answer = $vk->photos()->saveMarketPhoto($access_token, [
                        'group_id' => $group_id,
                        'photo' => $obj['photo'],
                        'server' => $obj['server'],
                        'hash' => $obj['hash'],
                        'crop_data' => $obj['crop_data'],
                        'crop_hash' => $obj['crop_hash'],
                    ]);

                    $response = $vk->market()->add($access_token, [
                        'owner_id' => -$group_id,
                        'name' => $model->name,
                        'description' => $model->description,
                        'category_id' => '1006',
                        'main_photo_id' => $answer[0]['id'],
                        'price' => $model->price,
                        'url' => $model->getDetail()
                    ]);

                    if (array_key_exists('market_item_id', $response)) {
                        $market_store = new ProductMarket();
                        $market_store->product_id = $model->id;
                        $market_store->market_id = $response['market_item_id'];
                        if ($market_store->validate()) {
                            $market_store->save();
                        }
                    }

                }
            }
        }
    }
}