<?php

namespace app\modules\catalog\models\form;

use app\modules\catalog\models\entity\Product;
use app\modules\catalog\models\entity\virtual\SibagroElement;
use app\modules\vendors\models\entity\Vendor;
use yii\base\Model;
use yii\web\UploadedFile;

class SibagroUploadForm extends Model
{
    public $file;
    public $dirPath;

    public function __construct($config = [])
    {
        parent::__construct($config);

        $this->dirPath = \Yii::getAlias('@app/tmp/');
    }

    public function rules()
    {
        return [
            ['file', 'file', 'extensions' => 'html']
        ];
    }

    public function prepareDir()
    {
        if (!$this->existDir()) return $this->createDir();

        return true;
    }

    public function existDir()
    {
        return is_dir($this->dirPath);
    }

    public function createDir()
    {
        return mkdir($this->dirPath);
    }

    public function parse()
    {
        $items = [];
        $fileName = 'file.html';
        $file = UploadedFile::getInstance($this, 'file');

        if (!$this->prepareDir()) throw new \Exception('Директория для хранения HTML файлов не создана или не существует.');

        $file->saveAs($this->dirPath . $fileName);

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
            $image = $this->getXpathObject($item->ownerDocument->saveHTML($item))->query("//div[@class='outer']//a");
            $price = $this->getPrice($this->getValue($price->item(0)));

            $statusAvail = $this->getXpathObject($item->ownerDocument->saveHTML($item))->query("//span[@class='sklad']");
            $statusWait = $this->getXpathObject($item->ownerDocument->saveHTML($item))->query("//span[@class='vputi']");


            $sibEl = new SibagroElement();
            $sibEl->name = $this->getValue($name->item(0));
            $sibEl->code = $this->getValue($code->item(0));
            $sibEl->price = $price;
            $sibEl->vendorId = Vendor::VENDOR_ID_SIBAGRO;
            $sibEl->imagePath = 'http://www.sat-altai.ru' . $image->item(0)->attributes->getNamedItem('href')->value;

            $sibEl->status = Product::STATUS_ACTIVE;
            if ($statusAvail) $sibEl->status = Product::STATUS_ACTIVE;
            if ($statusWait) $sibEl->status = Product::STATUS_WAIT;

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