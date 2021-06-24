<?php

use app\modules\site\models\tools\System;
use app\modules\catalog\models\helpers\ProductHelper;
use app\modules\vendors\models\entity\Vendor;

/* @var $offers \app\modules\catalog\models\entity\Product[]
 * @var $categories \app\modules\catalog\models\entity\ProductCategory[]
 * @var $module \app\modules\export\Module
 */
?>
<?= '<?xml version="1.0" encoding="UTF-8"?>'; ?>
<yml_catalog date="<?= date('Y-m-d H:i'); ?>">
    <shop>
        <name><?= $module->exportOrganizationName; ?></name>
        <company><?= $module->exportCompany; ?></company>
        <url><?= System::fullSiteUrl(); ?></url>
        <platform><?= $module->exportPlatform; ?></platform>
        <version><?= $module->exportVersion; ?></version>
        <agency></agency>
        <email></email>
        <currencies>
            <currency id="USD" rate="CBRF"/>
            <currency id="RUB" rate="1"/>
            <currency id="EUR" rate="CBRF"/>
        </currencies>
        <delivery-options>
            <option cost="0" days="1"/>
        </delivery-options>
        <categories>
            <?php foreach ($categories as $category): ?>
                <category id="<?= $category->id ?>" <?= $category->parent ? sprintf('parentId="%s"', $category->parent) : ''; ?>><?= $category->name; ?></category>
            <?php endforeach; ?>
        </categories>
        <cpa>1</cpa>
        <offers>
            <?php foreach ($offers as $offer): ?>
                <offer id="<?= $offer->id ?>" available="true">
                    <url><?= ProductHelper::getDetailUrl($offer, true); ?></url>
                    <?php if ($offer->barcode): ?>
                        <vendorCode><?= $offer->barcode ?></vendorCode>
                    <?php endif; ?>
                    <?php if ($offer->discount_price): ?>
                        <price><?= $offer->discount_price; ?></price>
                        <oldprice><?= $offer->price; ?></oldprice>
                    <?php else: ?>
                        <price><?= $offer->price; ?></price>
                    <?php endif; ?>
                    <currencyId>RUB</currencyId>
                    <categoryId><?= $offer->category_id; ?></categoryId>
                    <picture><?= ProductHelper::getImageUrl($offer); ?></picture>
                    <name><?= htmlspecialchars(strip_tags($offer->name)); ?></name>
                    <?php if (!empty($offer->description)): ?>
                        <description><?= htmlspecialchars(strip_tags($offer->description)); ?></description>
                    <?php endif; ?>
                    <pickup>true</pickup>
                    <store>false</store>
                    <delivery>true</delivery>

                    <?php if ($offer->vendor_id == Vendor::VENDOR_ID_SIBAGRO): ?>
                        <delivery-options>
                            <option cost="0" days="1"/>
                        </delivery-options>
                    <?php elseif ($offer->vendor_id == Vendor::VENDOR_ID_VALTA || $offer->vendor_id == Vendor::VENDOR_ID_SANABELLE || $offer->vendor_id == Vendor::VENDOR_ID_FORZA): ?>
                        <delivery-options>
                            <option cost="0" days="3-5"/>
                        </delivery-options>
                    <?php elseif ($offer->vendor_id == Vendor::VENDOR_ID_ROYAL): ?>
                        <delivery-options>
                            <option cost="0" days="0"/>
                        </delivery-options>
                    <?php else: ?>
                        <delivery-options>
                            <option cost="0" days="1"/>
                        </delivery-options>
                    <?php endif; ?>

                </offer>
            <?php endforeach; ?>
        </offers>
    </shop>
</yml_catalog>