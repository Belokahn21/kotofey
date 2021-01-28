<?php
/* @var $category \app\modules\catalog\models\entity\ProductCategory */
?>
<?php if ($category): ?>
    <ul class="catalog-categories">
        <?php foreach ($category->childs as $child): ?>
            <li class="catalog-categories__item">
                <div class="catalog-categories__header">
                    <div class="catalog-categories__icon"><img src="./assets/images/icon-block.png"></div>
                    <div class="catalog-categories__name"><?= $category->name; ?>/div>
                    </div>
                    <div class="catalog-categories-list">
                        <div class="catalog-categories-list__item"><a class="catalog-categories-list__link" href="javascript:void(0);">Газобетонные</a></div>
                        <div class="catalog-categories-list__item"><a class="catalog-categories-list__link" href="javascript:void(0);">Керамические</a></div>
                        <div class="catalog-categories-list__item"><a class="catalog-categories-list__link" href="javascript:void(0);">Керамзитобетонные</a></div>
                        <div class="catalog-categories-list__item"><a class="catalog-categories-list__link" href="javascript:void(0);">Бетонные</a></div>
                        <div class="catalog-categories-list__item"><a class="catalog-categories-list__link" href="javascript:void(0);">Фундаментные</a></div>
                        <div class="catalog-categories-list__item"><a class="catalog-categories-list__link" href="javascript:void(0);">Сетки для кладки</a></div>
                    </div>
            </li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>
