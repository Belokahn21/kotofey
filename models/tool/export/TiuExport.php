<?
/**
 * Developer: Konstantin Vasin by PhpStorm
 * Company: Altasib
 * Time: 15:15
 */

namespace app\models\tool\export;


use app\models\entity\Product;
use yii\helpers\Json;

class TiuExport
{
    private $associateCategories = [
        '1' => '152405', //Кошельки и портмоне
        '3' => '152413', // Обложки для документов
        '5' => '211115', // Визитницы и картхолдеры
    ];

    public function create()
    {
        $dom = new \DOMDocument("1.0", "utf-8");
        $offers = $dom->createElement('offers');
        $dom->appendChild($offers);

        /* @var $product Product */
        foreach (Product::find()->all() as $product) {
            $offer = $dom->createElement('offer');
            $offer->setAttribute('id', $product->article);
            $offer->setAttribute('available', "true");

            $name = $dom->createElement('name', htmlspecialchars($product->name));
            $barcode = $dom->createElement('barcode', $product->article);
            $price = $dom->createElement('price', $product->price);
            $quantity_in_stock = $dom->createElement('quantity_in_stock', $product->count);
            $currencyId = $dom->createElement('currencyId', "RUB");
            $vendor = $dom->createElement('vendor', 'eventhorizont');
            $description = $dom->createElement('description', $product->description);
            $available = $dom->createElement('available', 'В наличии');
            $categoryId = $dom->createElement('categoryId',!empty($this->associateCategories[$product->category]) ?: 33903);

            if (!empty($product->seo_keywords)) {
                $keywords = $dom->createElement('keywords', $product->seo_keywords);
                $offer->appendChild($keywords);
            }

            if (!empty($product->image)) {
                $picture = $dom->createElement('picture', "https://eventhorizont.ru".$product->image);
                $offer->appendChild($picture);
            }

            if (!empty($product->images)) {
                $images = Json::decode($product->images);
                foreach ($images as $image) {
                    $pictureMore = $dom->createElement('picture', "https://eventhorizont.ru".$image);
                    $offer->appendChild($pictureMore);
                }
            }

            $offer->appendChild($name);
            $offer->appendChild($barcode);
            $offer->appendChild($price);
            $offer->appendChild($quantity_in_stock);
            $offer->appendChild($currencyId);
            $offer->appendChild($vendor);
            $offer->appendChild($description);
            $offer->appendChild($available);
            $offer->appendChild($categoryId);

            $offers->appendChild($offer);
        }
        $dom->save(\Yii::getAlias('@app') . "/tiu.xml");
    }
}