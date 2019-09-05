<?

namespace app\models\tool\export;


use app\models\entity\Product;
use yii\helpers\Json;

class YMLExport
{

    public function create()
    {
        $dom = new \DOMDocument("1.0", "UTF-8");
        $yml_catalog = $dom->createElement('yml_catalog');
        $shop = $dom->createElement('shop');
        $offers = $dom->createElement('offers');

        $dom->appendChild($yml_catalog);

        $yml_catalog->setAttribute('date', date("Y-m-d H:i"));
        $yml_catalog->appendChild($shop);

        $shop->appendChild($offers);

        /* @var $product Product */
        foreach (Product::find()->all() as $product) {

            $offer = $dom->createElement('offer');
            $offer->setAttribute('id', $product->id);

            $name = $dom->createElement('name', htmlspecialchars($product->display));
            $offer->appendChild($name);

            $currencyId = $dom->createElement('currencyId', "RUB");
            $offer->appendChild($currencyId);

            $url = $dom->createElement('vendor', sprintf("https://eventhorizont.ru%s", $product->detail));
            $offer->appendChild($url);

            $price = $dom->createElement('price', $product->price);
            $offer->appendChild($price);

            $picture = $dom->createElement('picture', sprintf("https://eventhorizont.ru%s", $product->image));
            $offer->appendChild($picture);

            $categoryId = $dom->createElement('categoryId', $product->category);
            $offer->appendChild($categoryId);

            if (!empty($product->description)) {

                $description = $dom->createElement('description', $product->description);
                $offer->appendChild($description);

            }

            $delivery = $dom->createElement('delivery', "true");
            $offer->appendChild($delivery);

            $pickup = $dom->createElement('pickup', "true");
            $offer->appendChild($pickup);

            $offers->appendChild($offer);
        }
        $dom->save(\Yii::getAlias('@app') . "/web/export/yml.yml");
    }
}