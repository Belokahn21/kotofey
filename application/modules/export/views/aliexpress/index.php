<?php

use app\modules\site\models\tools\System;
use app\modules\vendors\models\entity\Vendor;
use app\modules\catalog\models\helpers\ProductHelper;
use app\modules\catalog\models\entity\Product;
use app\modules\catalog\models\helpers\PropertiesHelper;

/* @var $offersBatch
 * @var $offers \app\modules\catalog\models\entity\Product[]
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
        <categories>
            <?php foreach ($categories as $category): ?>
                <category id="<?= $category->id ?>" <?= $category->parent_category_id ? sprintf('parentId="%s"', $category->parent_category_id) : ''; ?>><?= $category->name; ?></category>
            <?php endforeach; ?>
        </categories>
        <cpa>1</cpa>
        <offers>
            <?php foreach ($offers as $offer): ?>

                <?php if ($offer->vendor_id == Vendor::VENDOR_ID_LUKAS and $offer->purchase < 5000) continue; ?>

                <?php
                $weight = PropertiesHelper::extractPropertyById($offer, 2);
                if (!$weight) continue;
                ?>


                <offer id="<?= $offer->id ?>" available="<?= ($offer->status_id == Product::STATUS_ACTIVE ? 'true' : 'false'); ?>">

                    <url><?= ProductHelper::getDetailUrl($offer, true); ?></url>

                    <?php if ($vendor = PropertiesHelper::extractPropertyById($offer, 1)): ?>
                        <vendor><?php $vendor->name; ?></vendor>
                    <?php endif; ?>
                    <?php if ($offer->barcode): ?>
                        <vendorCode><?= $offer->barcode ?></vendorCode>
                    <?php endif; ?>
                    <?php if ($offer->discount_price): ?>
                        <discountprice><?= $offer->discount_price; ?></discountprice>
                    <?php endif; ?>
                    <price><?= $offer->price; ?></price>


                    <currencyId>RUB</currencyId>
                    <categoryId><?= $offer->category_id; ?></categoryId>
                    <picture><?= ProductHelper::getImageUrl($offer, false, ['width' => 246, 'height' => 300, 'crop' => 'fit']); ?></picture>
                    <name><?= htmlspecialchars(strip_tags(\yii\helpers\StringHelper::truncate($offer->name, 128, false))); ?></name>
                    <?php if (!empty($offer->description)): ?>
                        <description><?= htmlspecialchars(strip_tags($offer->description)); ?></description>
                    <?php endif; ?>
                    <pickup>false</pickup>
                    <store>false</store>
                    <delivery>true</delivery>

                    <?php
                    $xValue = PropertiesHelper::extractPropertyById($offer, 16);
                    $yValue = PropertiesHelper::extractPropertyById($offer, 17);
                    $zValue = PropertiesHelper::extractPropertyById($offer, 18);
                    ?>
                    <?php if ($xValue && $yValue && $zValue): ?>
                        <dimensions><?= $xValue->value; ?>/<?= $yValue->value; ?>/<?= $zValue->value; ?></dimensions>
                    <?php endif; ?>



                    <?php if ($xValue): ?>
                        <width><?= $xValue->value; ?></width>
                    <?php endif; ?>

                    <?php if ($yValue): ?>
                        <height><?= $yValue->value; ?></height>
                    <?php endif; ?>

                    <?php if ($zValue): ?>
                        <length><?= $zValue->value; ?></length>
                    <?php endif; ?>


                    <?php if ($weight): ?>
                        <weight><?= $weight->value; ?></weight>
                    <?php endif; ?>

                    <count><?= $offer->vendor_id != Vendor::VENDOR_ID_ROYAL ? 0 : 500; ?></count>
                </offer>
            <?php endforeach; ?>
        </offers>
    </shop>
</yml_catalog>