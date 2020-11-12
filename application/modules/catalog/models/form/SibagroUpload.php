<?php

namespace app\modules\catalog\models\form;

use app\modules\catalog\models\entity\virtual\SibagroElement;
use app\modules\site\models\tools\Debug;
use app\modules\vendors\models\entity\Vendor;
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
        $items = [];
        $fileName = 'file.html';
        $file = UploadedFile::getInstance($this, 'file');

        $file->saveAs(\Yii::getAlias('@app/tmp/' . $fileName));

        $content = file_get_contents(\Yii::getAlias('@app/tmp/' . $fileName));

        $dom = new \DOMDocument();
//        $content = mb_convert_encoding($content, "ISO-8859-1", "utf-8");
        @$dom->loadHTML($content);
        $xpath = new \DOMXPath($dom);
        $sibagroElements = $xpath->query("//tr[@class='popoverp']");


        foreach ($sibagroElements as $item) {
            $name = $this->getXpathObject($item->ownerDocument->saveHTML($item))->query("//a[@class='product_name']");
            $code = $this->getXpathObject($item->ownerDocument->saveHTML($item))->query("//td[@class='product_code']");
            $price = $this->getXpathObject($item->ownerDocument->saveHTML($item))->query("//td[@class='lead']");

            $price = $this->getPrice($this->getValue($price->item(0)));

            $sibEl = new SibagroElement();
            $sibEl->name = $this->getValue($name->item(0));
            $sibEl->code = $this->getValue($code->item(0));
            $sibEl->price = $price;
            $sibEl->vendorId = Vendor::VENDOR_ID_SIBAGRO;


//            Debug::p($price);
//            exit();

            $items[] = $sibEl;
        }

        return $items;
    }

    public function getXpathObject($html)
    {
        $dom = new \DOMDocument();
        $dom->loadHtml($html);
        return new \DOMXPath($dom);
    }

    public function getValue($domItem)
    {
        return mb_convert_encoding($domItem->nodeValue, "ISO-8859-1", "utf-8");
    }

    public function getPrice($price)
    {
        $priceMatch = null;
        $rub = 0;
        $kop = 0;
        preg_match('/(\d+р\.) (\d+коп\.)/i', $price, $priceMatch);

        // нашел цену
        if (count($priceMatch) > 1)
            preg_match('/\d+/i', $priceMatch[1], $rub);

        // есть рубли и копейки
        if (count($priceMatch) == 3)
            preg_match('/\d+/i', $priceMatch[2], $kop);

        return round($rub[0] . '.' . $kop[0]);
    }
}