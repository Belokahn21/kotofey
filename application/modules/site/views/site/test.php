<?php

$product = \app\modules\catalog\models\entity\Product::findOne(9);
$ozon_prod = new \app\modules\marketplace\models\entity\OzonProduct();
$ozon_prod->loadAttrs($product);


if ($ozon_prod->validate()) {
    $ms = new \app\modules\marketplace\models\api\OzonApi();
    var_dump($ms->createProduct($ozon_prod));
} else {
    \app\modules\site\models\tools\Debug::p($ozon_prod->getErrors());
}


//$product = \app\modules\catalog\models\entity\Product::findOne(12);
//\app\modules\site\models\tools\Debug::p($product->formName());
?>

<?php
/*
$html = '
<tbody><tr class="commonheader">
				<td style="width: 217px"><b><font size="4">Район</font></b></td>
				<td style="width: 155px"><b><font size="4">Районный центр</font></b></td>
			</tr>
			<tr>
				<td style="width: 217px" height="19">Алейский район</td>
				<td width="151">г. Алейск</td>
			</tr>
			<tr>
				<td style="width: 217px" height="19">Алтайский район</td>
				<td>с. Алтайское</td>
			</tr>
			<tr>
				<td style="width: 217px" height="19">Баевский район</td>
				<td>с. Баево</td>
			</tr>
			<tr>
				<td style="width: 217px" height="19">Бийский район</td>
				<td>г. Бийск</td>
			</tr>
			<tr>
				<td style="width: 217px" height="19">Благовещенский район</td>
				<td>п. Благовещенка</td>
			</tr>
			<tr>
				<td style="width: 217px" height="19">Бурлинский район</td>
				<td>с. Бурла</td>
			</tr>
			<tr>
				<td style="width: 217px" height="19">Быстроистокский район</td>
				<td>с. Быстрый Исток</td>
			</tr>
			<tr>
				<td style="width: 217px" height="19">Волчихинский район</td>
				<td>с. Волчиха</td>
			</tr>
			<tr>
				<td style="width: 217px" height="19">Егорьевский район</td>
				<td>с. Новоегорьевское</td>
			</tr>
			<tr>
				<td style="width: 217px" height="19">Ельцовский район</td>
				<td>с. Ельцовка</td>
			</tr>
			<tr>
				<td style="width: 217px" height="19">Завьяловский район</td>
				<td>с. Завьялово</td>
			</tr>
			<tr>
				<td style="width: 217px" height="19">Залесовский район</td>
				<td>с. Залесово</td>
			</tr>
			<tr>
				<td style="width: 217px" height="19">Заринский район</td>
				<td>г. Заринск</td>
			</tr>
			<tr>
				<td style="width: 217px" height="19">Змеиногорский район</td>
				<td>г. Змеиногорск</td>
			</tr>
			<tr>
				<td style="width: 217px" height="19">Зональный район</td>
				<td>с. Зональное</td>
			</tr>
			<tr>
							<td height="19">Калманский район</td>
							<td>с. Калманка</td>
			</tr>
			<tr>
							<td height="19">Каменский район</td>
							<td>г. Камень-на-Оби</td>
			</tr>
			<tr>
							<td height="19">Ключевский район</td>
							<td>с. Ключи</td>
			</tr>
			<tr>
							<td height="19">Косихинский район</td>
							<td>с. Косиха</td>
			</tr>
			<tr>
							<td height="19">Красногорский район</td>
							<td>с. Красногорское</td>
			</tr>
			<tr>
							<td height="19">Краснощёковский район</td>
							<td>с. Краснощёково</td>
			</tr>
			<tr>
							<td height="19">Крутихинский район</td>
							<td>с. Крутиха</td>
			</tr>
			<tr>
							<td height="19">Кулундинский район</td>
							<td>с. Кулунда</td>
			</tr>
			<tr>
							<td height="19">Курьинский район</td>
							<td>с. Курья</td>
			</tr>
			<tr>
							<td height="19">Кытмановский район</td>
							<td>с. Кытманово</td>
			</tr>
			<tr>
							<td height="19">Локтевский район</td>
							<td>г. Горняк</td>
			</tr>

			<tr>
							<td height="19">Мамонтовский район</td>
							<td>с. Мамонтово</td>
			</tr>
			<tr>
							<td height="19">Михайловский район</td>
							<td>с. Михайловский</td>
			</tr>
			<tr>
							<td height="19">Немецкий национальный район</td>
							<td>с. Гальбштадт</td>
			</tr>
			<tr>
							<td height="19">Новичихинский район</td>
							<td>с. Новичиха</td>
			</tr>
			<tr>
							<td height="19">Павловский район</td>
							<td>с. Павловск</td>
			</tr>
			<tr>
							<td height="19">Панкрушихинский район</td>
							<td>с. Панкрушиха</td>
			</tr>
			<tr>
							<td height="19">Первомайский район</td>
							<td>г. Новоалтайск</td>
			</tr>
			<tr>
							<td height="19">Петропавловский район</td>
							<td>с. Петропавловское</td>
			</tr>
			<tr>
							<td height="19">Поспелихинский район</td>
							<td>с. Поспелиха</td>
			</tr>
			<tr>
							<td height="19">Ребрихинский район</td>
							<td>с. Ребриха</td>
			</tr>
			<tr>
							<td height="19">Родинский район</td>
							<td>с. Родино</td>
			</tr>
			<tr>
							<td height="19">Романовский район</td>
							<td>с. Романово</td>
			</tr>
			<tr>
							<td height="19">Рубцовский район</td>
							<td>г. Рубцовск</td>
			</tr>
			<tr>
							<td height="19">Славгородский район</td>
							<td>г. Славгород</td>
			</tr>
			<tr>
							<td height="19">Смоленский район</td>
							<td>с. Смоленское</td>
			</tr>
			<tr>
							<td height="19">Суетский район</td>
							<td>с. Верх-Суетка</td>
			</tr>
			<tr>
							<td height="19">Советский район</td>
							<td>с. Советское</td>
			</tr>
			<tr>
							<td height="19">Солонешенский район</td>
							<td>с. Солонешное</td>
			</tr>
			<tr>
							<td height="19">Солтонский район</td>
							<td>с. Солтон</td>
			</tr>
			<tr>
							<td height="19">Шелаболихинский район</td>
							<td>с. Шелаболиха</td>
			</tr>
			<tr>
							<td height="19">Табунский район</td>
							<td>с. Табуны</td>
			</tr>
			<tr>
							<td height="19">Тальменский район</td>
							<td>п. Тальменка</td>
			</tr>
			<tr>
							<td height="19">Тогульский район</td>
							<td>с. Тогул</td>
			</tr>
			<tr>
							<td height="19">Топчихинский район</td>
							<td>с. Топчиха</td>
			</tr>
			<tr>
							<td height="19">Третьяковский район</td>
							<td>с. Староалейское</td>
			</tr>
			<tr>
							<td height="19">Троицкий район</td>
							<td>с. Троицкое</td>
			</tr>
			<tr>
							<td height="19">Тюменцевский район</td>
							<td>с. Тюменцево</td>
			</tr>
			<tr>
							<td height="19">Угловский район</td>
							<td>с. Угловское</td>
			</tr>
			<tr>
							<td height="19">Усть-Калманский район</td>
							<td>с. Усть-Калманка</td>
			</tr>
			<tr>
							<td height="19">Усть-Пристанский район</td>
							<td>с. Усть-Чарышская Пристань</td>
			</tr>
			<tr>
							<td height="19">Хабарский район</td>
							<td>с. Хабары</td>
			</tr>
			<tr>
							<td height="19">Целинный район</td>
							<td>с. Целинное</td>
			</tr>
			<tr>
							<td height="19">Чарышский район</td>
							<td>с. Чарышское</td>
			</tr>
			<tr>
							<td height="19">Шипуновский район</td>
							<td>с. Шипуново</td>
			</tr>
		</tbody>';


$dom = new \DOMDocument();
$dom->loadHTML('<?xml encoding="utf-8" ?>' . $html, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD | LIBXML_NOERROR | LIBXML_NOWARNING);

$xpath = new \DOMXPath($dom);
$els = $xpath->query('//tr');

$data = [];

foreach ($els as $el) {
    $value = $el->getElementsByTagName('td')->item(0)->nodeValue;

    $data[] = $value;

//    $data[] = iconv(mb_detect_encoding($el->nodeValue, mb_detect_order(), true), "UTF-8//IGNORE", $el->nodeValue);
}

echo implode(',', $data);
//file_put_contents('demo.txt', implode(',', $data));

