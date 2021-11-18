<?php
/* @var $history \app\modules\catalog\models\entity\ProductPriceHistory */

use CpChart\Data;
use CpChart\Image;
use yii\helpers\ArrayHelper;

$data = new Data();
$arData = [];
foreach ($history as $item) {
    $data->addPoints(ArrayHelper::getValue($item, 'value'), "Цены");
}
$data->setAxisName(0, "Цены");

$image = new Image(1100, 230, $data);
$image->Antialias = false;
$image->drawRectangle(0, 0, 1099, 229, ["R" => 0, "G" => 0, "B" => 0]);
$image->setFontProperties(["FontName" => "verdana.ttf", "FontSize" => 11]);
$image->setFontProperties(["FontName" => "verdana.ttf", "FontSize" => 6]);
$image->setGraphArea(60, 40, 1099, 200);
$scaleSettings = [
    "XMargin" => 10,
    "YMargin" => 10,
    "Floating" => true,
    "GridR" => 200,
    "GridG" => 200,
    "GridB" => 200,
    "DrawSubTicks" => true,
    "CycleBackground" => true
];
$image->drawScale($scaleSettings);
$image->drawLegend(600, 20, ["Style" => LEGEND_NOBORDER, "Mode" => LEGEND_HORIZONTAL]);
$image->Antialias = true;
$image->setShadow(true, ["X" => 1, "Y" => 1, "R" => 0, "G" => 0, "B" => 0, "Alpha" => 10]);
$Threshold = [];
$Threshold[] = ["Min" => 0, "Max" => 5, "R" => 207, "G" => 240, "B" => 20, "Alpha" => 70];
$Threshold[] = ["Min" => 5, "Max" => 10, "R" => 240, "G" => 232, "B" => 20, "Alpha" => 70];
$Threshold[] = ["Min" => 10, "Max" => 20, "R" => 240, "G" => 191, "B" => 20, "Alpha" => 70];
$image->drawAreaChart(["Threshold" => $Threshold]);
$image->drawThreshold(5, ["WriteCaption" => true, "Caption" => "Warn Zone", "Alpha" => 70, "Ticks" => 2, "R" => 0, "G" => 0, "B" => 255]);
$image->drawThreshold(10, ["WriteCaption" => true, "Caption" => "Error Zone", "Alpha" => 70, "Ticks" => 2, "R" => 0, "G" => 0, "B" => 255]);
$file_name = '/assets/example.drawAreaChart.threshold.png';
$file_path = Yii::getAlias("@webroot$file_name");
$image->render($file_path);
?>

<img src="<?= $file_name; ?>"/>
