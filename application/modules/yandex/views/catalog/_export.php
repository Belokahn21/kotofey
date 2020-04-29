<?= $this->getXmlHead(); ?>
<yml_catalog date="<?= date('Y-m-d H:i'); ?>">
    <shop>
        <name>Алтайский источник</name>
        <company>Алтайский источник</company>
        <url>https://alt-ist.ru/</url>
        <platform>Алтайский источник</platform>
        <version>1.2</version>
        <agency></agency>
        <email></email>
        <currencies>
			<?php foreach ($currencies as $currency): ?>
                <currency id="<?= $currency; ?>" <?= $currency === 'RUB' ? 'rate="1"' : 'rate="CBRF"'; ?>/>
			<?php endforeach; ?>
        </currencies>
        <categories>
			<?php foreach ($categories as $category): ?>
                <category id="<?= $category->id ?>" <?= $category->parent_id ? sprintf('parentId="%s"', $category->parent_id) : ''; ?>><?= $category->name; ?></category>
			<?php endforeach; ?>
        </categories>
        <cpa>1</cpa>
        <offers>
			<?php foreach ($offers as $offer): ?>
                <offer id="<?= $offer->id ?>" available="<?= $offer->isInStock() ? 'true' : 'false'; ?>">
                    <url><?= CHtml::normalizeUrl(Yii::app()->getBaseUrl(true) . ProductHelper::getItemUrl($offer)); ?></url>
                    <price><?= $offer->getResultPrice(); ?></price>
					<?php if ($offer->getBasePrice() != $offer->getResultPrice()): ?>
                        <oldprice><?= $offer->getBasePrice(); ?></oldprice>
					<?php endif; ?>
                    <currencyId><?= Yii::app()->getModule('store')->currency; ?></currencyId>
                    <categoryId><?= $offer->category_id; ?></categoryId>
                    <picture><?= StoreImage::product($offer); ?></picture>
                    <name><?= htmlspecialchars(strip_tags($offer->getNameWithRequiredAttributes())); ?></name>
                    <description><?= htmlspecialchars(strip_tags($offer->description)); ?></description>
					<?php foreach ($offer->attributes() as $attr): ?>
                        <param name="<?= $attr->attribute->title; ?>" <?php if ($attr->attribute->unit): ?> unit="<?= strip_tags($attr->attribute->unit); ?>" <?php endif; ?>>
							<?= htmlspecialchars(strip_tags($attr->value())); ?>
                        </param>
					<?php endforeach; ?>
                </offer>
			<?php endforeach; ?>
        </offers>
    </shop>
</yml_catalog>