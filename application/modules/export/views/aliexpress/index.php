<?php

use app\models\tool\System;
use app\modules\catalog\models\helpers\ProductHelper;
use app\modules\catalog\models\entity\Product;
use app\modules\catalog\models\helpers\ProductPropertiesHelper;
use app\modules\export\models\tools\AliexpressHelper;

$module = Yii::$app->getModule('export');

/* @var $offers \app\modules\catalog\models\entity\Product[]
 * @var $categories \app\modules\catalog\models\entity\Category[]
 */
?>
<?xml version="1.0" encoding="UTF-8"?>
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
            <?php foreach ($offers as $offer): ?>
                <?php $properties = ProductPropertiesHelper::getAllProperties($offer->id); ?>
                <offer id="<?= $offer->id ?>" available="<?= ($offer->status_id == Product::STATUS_ACTIVE ? 'true' : 'false'); ?>">
                    <url><?= ProductHelper::getDetailUrl($offer, true); ?></url>
                    <?php if ($offer->discount_price): ?>
                        <price><?= $offer->discount_price; ?></price>
                        <oldprice><?= $offer->price; ?></oldprice>
                    <?php else: ?>
                        <price><?= $offer->price; ?></price>
                    <?php endif; ?>
                    <currencyId>RUB</currencyId>
                    <categoryId><?= $offer->category_id; ?></categoryId>
                    <picture><?= ProductHelper::getImageUrl($offer,[
                            'crop'=>'fit'
                        ]); ?></picture>
                    <name><?= htmlspecialchars(strip_tags($offer->name)); ?></name>
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
                    <?php if ($properties && array_key_exists(2, $properties)): ?>
                        <weight><?= AliexpressHelper::getRealWeight($properties[2], [
                                'width' => @$properties[16],
                                'height' => @$properties[17],
                                'length' => @$properties[18],
                            ]); ?></weight>
                    <?php endif; ?>
                    <count><?= rand(20, 40); ?></count>
                </offer>
            <?php endforeach; ?>
        </offers>
    </shop>
</yml_catalog>