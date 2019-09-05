<?

use app\models\tool\delivery\kladr\Regions;
use app\models\tool\delivery\calc\Dellin;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use app\models\tool\delivery\calc\CalculateDelllin;


?>


    <form method="get" class="geoData" action="/test/">
        <div>
            <input type="text" name="position" class="geoData_pos">
            <div class="response"></div>
            <input type="hidden" name="filter[derivalPoint]" class="geoData_code">
        </div>

        <button type="submit">Поиск</button>
    </form>

<style>
    .response{color: white; margin: 2% 0; padding: 1%;}
</style>
<?
$dellin = new Dellin();

$calucate = new CalculateDelllin();
$calucate->setSessionID($dellin->getSessionID());

$info = $calucate->calc($_GET['filter']);

echo "<pre>";
print_r($info);
//print_r($info['derival']['terminals']);
echo "</pre>";


//$page = file_get_contents("https://kladr-rf.ru/");
//
//if (!empty($page)) {
//
//    Yii::$app->db->createCommand()->truncateTable('kladr_regions')->execute();
//
//    preg_match_all('/<a href=\"((https|http):\/\/kladr-rf\.ru\/\d{2}\/)\">(.*)<\/a>/iU', $page, $regionList);
//
//    echo "<pre>";
//    foreach ($regionList[1] as $count_id => $regionLink) {
//        $regionInfo = file_get_contents($regionLink);
//
//        // find kladr
//        preg_match_all("/<ul class=\"breadcrumb\">(.+)<\/ul>/iU", $regionInfo, $kladrData);
//
//        $name = "";
//        $kladrRegion = "";
//        foreach ($kladrData[1] as $item) {
//
//            preg_match("/<li>Код КЛАДР: <strong><em>(\d+)<\/em><\/strong><\/li>/iU", $item, $findKladr);
//            if(count($findKladr) > 0){
//                $kladrRegion = $findKladr[1];
//            }
//
//        }
//
//
//
//        //find other info
//        preg_match_all("/<table class=\"table table-bordered table-hover\">(.+)<\/table>/iU", $regionInfo, $otherInfo);
//        preg_match_all("/<td>(.+)<\/td>/iU", $otherInfo[0][0], $otherInfoData);
//
////        print_r($otherInfoData);
//        $kod_region = ($otherInfoData[1][0] != "-") ? $otherInfoData[1][0] : null;
//        $index = ($otherInfoData[1][1] != "-") ? $otherInfoData[1][1] : null;
//        $okato = ($otherInfoData[1][2] != "-") ? $otherInfoData[1][2] : null;
//        $kod_nalog = ($otherInfoData[1][3] != "-") ? $otherInfoData[1][3] : null;
//
//        $region = new Regions();
//        $region->name = $regionList[3][$count_id];
//        $region->code_kladr = $kladrRegion;
//
//        $region->mail_index = $index;
//        $region->okato = $okato;
//        $region->kod_region = $kod_region;
//        $region->tax_code = $kod_nalog;
//
//        $region->save();
//
//
//
////        return;
//
//
//    }
//    echo "</pre>";
//
//}