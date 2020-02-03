<?php

use app\models\helpers\ProductHelper;

/* @var $offers \app\models\entity\Product[] */
/* @var $categories \app\models\entity\Category[] */
?>
<?xml version="1.0" encoding="UTF-8"?>
<yml_catalog date="<?= date('Y-m-d H:i'); ?>">
    <shop>
        <name>Зоомагазин Котофей</name>
        <company>ИП Васин К.В.</company>
        <url>https://kotofey.store/</url>
        <platform>Зоомагазин Котофей</platform>
        <version>1.0</version>
        <agency></agency>
        <email></email>
        <currencies>
            <currency id="USD" rate="CBRF"/>
            <currency id="RUB" rate="1"/>
            <currency id="EUR" rate="CBRF"/>
        </currencies>
        <categories>
			<?php foreach ($categories as $category): ?>
                <category id="<?= $category->id ?>" <?= $category->parent ? sprintf('parentId="%s"', $category->parent) : ''; ?>><?= $category->name; ?></category>
			<?php endforeach; ?>
        </categories>
        <cpa>1</cpa>
        <offers>
			<?php foreach ($offers as $offer): ?>
                <offer id="<?= $offer->id ?>" available="true">
                    <url><?= $offer->detail; ?></url>
                    <price><?= ProductHelper::getResultPrice($offer); ?></price>
                    <currencyId>RUB</currencyId>
                    <categoryId><?= $offer->category_id; ?></categoryId>
                    <picture><?= $offer->image; ?></picture>
                    <name><?= htmlspecialchars(strip_tags($offer->name)); ?></name>
                    <description><?= htmlspecialchars(strip_tags($offer->description)); ?></description>
                </offer>
			<?php endforeach; ?>
        </offers>
    </shop>
</yml_catalog>