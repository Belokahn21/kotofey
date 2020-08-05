<?php

use app\modules\basket\models\entity\Basket;
use app\modules\catalog\models\entity\ProductPropertiesValues;
use app\modules\bonus\models\helper\DiscountHelper;
use app\models\tool\seo\Title;
use app\models\tool\Currency;
use app\modules\site_settings\models\entity\SiteSettings;
use yii\widgets\LinkPager;

/* @var $products \app\modules\catalog\models\entity\Product[] */

$this->title = Title::showTitle("Поиск по сайту");
$this->params['breadcrumbs'][] = ['label' => 'Поиск по сайту', 'url' => ['/search/']]; ?>
<div class="page">
    <ul class="breadcrumbs">
        <li class="breadcrumbs__item"><a class="breadcrumbs__link" href="javascript:void(0);">Главная</a></li>
        <li class="breadcrumbs__item active"><a class="breadcrumbs__link" href="javascript:void(0);">Поиск по сайту</a></li>
    </ul>
    <h1 class="page__title">Результат поиска:</h1>
	<?php if ($products): ?>
        <ul class="catalog">
			<?php foreach ($products as $product): ?>
				<?= $this->render('@app/modules/catalog/views/__item', [
					'product' => $product
				]); ?>
			<?php endforeach; ?>
        </ul>

        <div class="pagination-wrap">
			<?php echo LinkPager::widget([
				'pagination' => $pagerItems,
			]); ?>
        </div>

	<?php else: ?>
        <p style="text-align: center; margin: 20px 0; padding: 0 10px;">
            К сожаление ничего не нашлось :(
        </p>
        <p style="text-align: center;margin: 20px 0; padding: 0 10px;">
            Попробуйте изменить тактику поиска, поменяв язык. К примеру искали <strong>"Проплан"</strong> попробуйте <strong>"Pro plan"</strong>
        </p>
        <p style="text-align: center;margin: 20px 0; padding: 0 10px;">
            Позвоните нам по номеру <a href="tel:<?= SiteSettings::getValueByCode('phone_1'); ?>" class="js-phone-mask" style="color: #ff1a4a; font-weight: bold;"><?= SiteSettings::getValueByCode('phone_1'); ?></a> и мы быстро найдем ваш товар
        </p>
        <p style="text-align: center;margin: 20px 0; padding: 0 10px;">
            Или воспользуйтесь чатом в правом нижнем углу, мы отвечаем <span style="color: #ff1a4a; font-weight: bold; text-transform: uppercase;">моментально</span>
        </p>
        <img src="/upload/images/chat.png" style="width: auto; margin: 0 auto 50px auto; display: block;">
	<?php endif; ?>
</div>
