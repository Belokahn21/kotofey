<?php

namespace app\modules\catalog\models\form;

use app\modules\catalog\models\entity\virtual\SibagroElement;
use app\modules\site\models\tools\Debug;
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

//        $content = mb_convert_encoding($content, 'HTML-ENTITIES', 'UTF-8');
//        $fileContent = mb_convert_encoding($content, 'HTML-ENTITIES', 'iso-8859-1');
//        $content = mb_convert_encoding($content, 'iso-8859-1', 'utf8');
//        $content = mb_convert_encoding($content, 'utf8', 'windows-1251');
//        $content = mb_convert_encoding($content, 'CP1252', 'ISO-8859-5');
//        $content = mb_convert_encoding($content, 'iso-8859-1', 'CP1252');
//        $content = mb_convert_encoding($content, 'CP1252', 'utf8');
//        $content = mb_convert_encoding($content, 'ISO-8859-5', 'utf8');

        $dom = new \DOMDocument();
        @$dom->loadHTML($content);
        $xpath = new \DOMXPath($dom);
        $items = $xpath->query("//tr[@class='popoverp']");


        foreach ($items as $item) {
            $name = $this->getXpathObject($item->ownerDocument->saveHTML($item))->query("//a[@class='product_name']");
            $code = $this->getXpathObject($item->ownerDocument->saveHTML($item))->query("//td[@class='product_code']");
            $price = $this->getXpathObject($item->ownerDocument->saveHTML($item))->query("//td[@class='lead']");

            $sibEl = new SibagroElement();
            $sibEl->name = $name->item(0)->textContent;
            $sibEl->code = $code->item(0)->nodeValue;

            Debug::p($name->item(0)->textContent);

            exit();

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
}