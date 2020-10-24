<?php

use app\modules\catalog\models\helpers\ProductHelper;
use app\modules\catalog\models\entity\Product;

/* @var $offers \app\modules\catalog\models\entity\Product[]
 * @var $categories \app\modules\catalog\models\entity\Category[]
 */
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
        <delivery-options>
            <option cost="0" days="0"/>
        </delivery-options>
        <cpa>1</cpa>
        <offers>
            <?php foreach ($offers as $offer): ?>
                <offer id="<?= $offer->id ?>" available="<?= ($offer->status_id == Product::STATUS_ACTIVE ? 'true' : 'false'); ?>">
                    <url>https://kotofey.store<?= $offer->detail; ?></url>
                    <?php if ($offer->discount_price): ?>
                        <price><?= $offer->discount_price; ?></price>
                        <oldprice><?= $offer->price; ?></oldprice>
                    <?php else: ?>
                        <price><?= $offer->price; ?></price>
                    <?php endif; ?>
                    <currencyId>RUB</currencyId>
                    <categoryId><?= $offer->category_id; ?></categoryId>
                    <picture>https://kotofey.store/upload/<?= $offer->image; ?></picture>
                    <name><?= htmlspecialchars(strip_tags($offer->name)); ?></name>
                    <?php if (!empty($offer->description)): ?>
                        <description><?= htmlspecialchars(strip_tags($offer->description)); ?></description>
                    <?php endif; ?>
                    <pickup>false</pickup>
                    <store>false</store>
                    <delivery>true</delivery>
                </offer>
            <?php endforeach; ?>
        </offers>
    </shop>
</yml_catalog>