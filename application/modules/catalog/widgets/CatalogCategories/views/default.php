<?php

use app\modules\catalog\models\helpers\CategoryHelper;

/* @var $categories \app\modules\catalog\models\entity\ProductCategory[] */
?>
<?php if ($categories): ?>
    <ul class="catalog-categories">
        <?php foreach ($categories as $category): ?>
            <li class="catalog-categories__item">
                <div class="catalog-categories__header">
                    <div class="catalog-categories__icon"><img src="<?= CategoryHelper::getImageUrl($category); ?>" alt="<?= $category->name; ?>" title="<?= $category->name; ?>"></div>
                    <div class="catalog-categories__name">
                        <a class="catalog-categories__link" href="<?= CategoryHelper::getDetailUrl($category); ?>"><?= $category->name; ?></a>
                    </div>
                </div>

                <div class="catalog-categories-list">
                    <?php foreach ($category->childs as $child): ?>
                        <div class="catalog-categories-list__item">
                            <a class="catalog-categories-list__link" href="<?= CategoryHelper::getDetailUrl($child); ?>"><?= $child->name; ?></a>
                        </div>
                    <?php endforeach; ?>
                </div>
            </li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>
