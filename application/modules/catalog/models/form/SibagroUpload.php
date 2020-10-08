<?php

namespace app\modules\catalog\models\form;


use app\modules\catalog\models\entity\Product;
use Sunra\PhpSimple\HtmlDomParser;
use yii\base\Model;
use yii\web\UploadedFile;

class SibagroUpload extends Model
{
    public $file;

    public function rules()
    {
        return [
            ['file', 'file', 'extensions' => 'html']
        ];
    }

    public function parse()
    {
        $fileName = 'file.html';
        $file = UploadedFile::getInstance($this, 'file');

        $file->saveAs(\Yii::getAlias('@app/tmp/' . $fileName));

        $content = file_get_contents(\Yii::getAlias('@app/tmp/' . $fileName));


        $dom = HtmlDomParser::str_get_html($content);

        $items = $dom->find('.popoverp');

        foreach ($items as $item) {

            $code = $item->find('.product_ps div', 0)->innertext();
            preg_match('/\d+/', $code, $code);
            $code = $code[0];

            $price = $item->find('.lead span', 0)->innertext();
            preg_match('/\d+р./', $price, $price);
            $price = $price[0];
            preg_match('/\d+/', $price, $price);
            $price = $price[0];

            $product = Product::findOne(['code' => $code]);

            if (!$product) {
                continue;
            }

            $oldPrice = $product->price;
            $oldPurchase = $product->purchase;

            if ($oldPurchase == $price) {
                continue;
            }

            $oldPercent = ceil((($product->price - $product->purchase) / $product->purchase) * 100);
            $oldPercent = $oldPercent / 100;

            $product->scenario = Product::SCENARIO_UPDATE_PRODUCT;
            $product->purchase = $price;
            $product->price = $product->purchase + ceil($product->purchase * $oldPercent);

            if (!$product->validate()) {
                echo $product->name . "<br/>";
                print_r($product->getErrors());
                return false;
            }

            if ($product->update()) {
                echo $product->name . ' = ' . " (oldPrice: $oldPrice) " . $product->price . "<br/>";
            }

        }

    }
}