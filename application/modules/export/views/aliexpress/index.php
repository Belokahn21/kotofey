<?php

use app\models\tool\System;
use app\modules\vendors\models\entity\Vendor;
use app\modules\catalog\models\helpers\ProductHelper;
use app\modules\catalog\models\entity\Product;
use app\modules\catalog\models\helpers\ProductPropertiesHelper;
use app\modules\export\models\tools\AliexpressHelper;

$module = Yii::$app->getModule('export');

/* @var $offersBatch
 * @var $offers \app\modules\catalog\models\entity\Product[]
 * @var $categories \app\modules\catalog\models\entity\Category[]
 */
?>
<?= '<?xml version="1.0" encoding="UTF-8"?>'; ?>
<yml_catalog date="<?= date('Y-m-d H:i'); ?>">
    <shop>
        <name><?= $module->exportOrganizationName; ?></name>
        <company><?= $module->exportCompany; ?></company>
        <url><?= System::fullDomain(); ?></url>
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
                <category id="<?= $category->id ?>" <?= $category->parent ? sprintf('parentId="%s"', $category->parent) : ''; ?>><?= $category->name; ?></category>
            <?php endforeach; ?>
        </categories>
        <delivery-options>
            <option cost="0" days="0"/>
        </delivery-options>
        <cpa>1</cpa>
        <offers>
            <?php foreach ($offersBatch->batch(780) as $offers): ?>
                <?php foreach ($offers as $offer): ?>
                    <?php if ($offer->vendor_id == Vendor::VENDOR_ID_LUKAS and $offer->purchase < 5000) continue; ?>
                    <?php $properties = ProductPropertiesHelper::getAllProperties($offer->id, [2, 16, 17, 18]); ?>
                    <?php if (!array_key_exists(2, $properties)) continue; ?>
                    <offer id="<?= $offer->id ?>" available="<?= ($offer->status_id == Product::STATUS_ACTIVE ? 'true' : 'false'); ?>">
                        <url><?= ProductHelper::getDetailUrl($offer, true); ?></url>
                        <?php if ($vendor = AliexpressHelper::getVendorName($properties)): ?>
                            <vendor><?= $vendor; ?></vendor>
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
                        <picture><?= ProductHelper::getImageUrl($offer, false, ['width' => 800, 'height' => 800, 'crop' => 'fit']); ?></picture>
                        <name><?= htmlspecialchars(strip_tags(\yii\helpers\StringHelper::truncate($offer->name, 128, false))); ?></name>
                        <?php if (!empty($offer->description)): ?>
                            <description><?= htmlspecialchars(strip_tags($offer->description)); ?></description>
                        <?php endif; ?>
                        <pickup>false</pickup>
                        <store>false</store>
                        <delivery>true</delivery>
                        <?php if ($properties && array_key_exists(16, $properties) && array_key_exists(17, $properties) && array_key_exists(18, $properties)): ?>
                            <dimensions><?= $properties[16]; ?>/<?= $properties[17]; ?>/<?= $properties[18]; ?></dimensions>
                        <?php endif; ?>
                        <?php if ($properties && array_key_exists(16, $properties)): ?>
                            <width><?= $properties[16]; ?></width>
                        <?php endif; ?>
                        <?php if ($properties && array_key_exists(17, $properties)): ?>
                            <height><?= $properties[17]; ?></height>
                        <?php endif; ?>
                        <?php if ($properties && array_key_exists(18, $properties)): ?>
                            <length><?= $properties[18]; ?></length>
                        <?php endif; ?>
                        <?php if (array_key_exists(2, $properties)): ?>
                            <weight><?= $properties[2]; ?></weight>
                        <?php endif; ?>
                        <count><?= rand(20, 40); ?></count>
                    </offer>
                <?php endforeach; ?>
            <?php endforeach; ?>
        </offers>
    </shop>
</yml_catalog>