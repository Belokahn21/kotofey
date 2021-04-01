<?php

use app\modules\catalog\models\helpers\CategoryHelper;
use app\modules\catalog\models\entity\ProductCategory;

/* @var $categories \app\modules\catalog\models\entity\ProductCategory[]
 * @var $subCategories \app\modules\catalog\models\entity\ProductCategory[]
 */
?>
<?php if ($categories): ?>
    <ul class="footer-categories">
        <?php foreach ($categories as $item): ?>
            <li class="footer-categories__item is-parent">
                <a class="footer-categories__link" href="<?= CategoryHelper::getDetailUrl($item); ?>"><?= $item->name; ?></a>
            </li>

            <?php $subCategories = ProductCategory::find()->where(['parent' => $item->id])->all(); ?>
            <?php if ($subCategories): ?>
                <?php foreach ($subCategories as $element): ?>
                    <li class="footer-categories__item">
                        <a class="footer-categories__link" href="<?= CategoryHelper::getDetailUrl($element); ?>"><?= $element->name; ?></a>
                    </li>
                <?php endforeach; ?>
            <?php endif; ?>

        <?php endforeach; ?>
    </ul>
<?php endif; ?>