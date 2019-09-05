<?
require_once '../simple_html_dom.php';
?>
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<?
$ids = array(12309221,);
//$ids = array(12309221, 12309194);

foreach ($ids as $id) {
    $page = \app\models\tool\Cron::post("https://shop.purina.ru/catalogsearch/result/", [
        'q' => $id
    ]);

    \app\models\tool\Debug::printFile($page, true);
    $page = file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/web/debug.html");

    $html = str_get_html($page);

    $links = array();
    $productPage = "";
    foreach ($html->find('div.short-descr h3 a') as $a) {
//        \app\models\tool\Debug::printFile(file_get_contents($a->href), true);
        $productPage = file_get_html($a->href);
    }


    $page = str_get_html($productPage);

    $title = $page->find('h1.page-title')[0]->plaintext;
    $arTitle = explode(",", $title);
    $title = $arTitle[0];

    $desc = $page->find('div.short-descr')[0]->plaintext;
    $desc = trim($desc);
    $desc = htmlspecialchars($desc);

    $sku = $page->find('span.sku.sku__container span')[0]->plaintext;


    $price = (integer)$page->find('div.price span')[0]->plaintext;
    $imageLink = $page->find('.owl-item.active div img')[0]->src;


    $weight = array_pop($arTitle);
    $arWeight = explode(" ", $weight);

    switch ($arWeight[1]) {
        case "кг":
            $weight = $arWeight[0];
            break;

        case "г":
            $weight = round($arWeight[0] / 1000, 3);
            break;
    }


    \app\models\tool\Debug::p($title);
    \app\models\tool\Debug::p($desc);
    \app\models\tool\Debug::p($sku);
    \app\models\tool\Debug::p($price);
    \app\models\tool\Debug::p($imageLink);
    \app\models\tool\Debug::p($weight);


    $product = new \app\models\entity\Product();
    $product->name = "Purina " . $title;
    $product->description = $desc;
    $product->article = $sku;
    $product->count = 1;
    $product->vitrine = 1;
    $product->stock_id = 1;

    $product->properties[1] = "6";
    $product->properties[2] = $weight;


//    $product->createProduct();

    ?>


<? } ?>