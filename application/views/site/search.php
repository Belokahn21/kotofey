<?php

use app\models\entity\Basket;
use app\models\entity\ProductPropertiesValues;
use app\models\helpers\DiscountHelper;
use app\models\tool\seo\Title;
use app\models\tool\Currency;
use app\models\entity\SiteSettings;
use yii\widgets\LinkPager;

/* @var $products \app\models\entity\Product[] */

$this->title = Title::showTitle("Поиск по сайту");
$this->params['breadcrumbs'][] = ['label' => 'Поиск по сайту', 'url' => ['/search/']]; ?>
<?php if ($products): ?>
    <ul class="catalog-list w-100">
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
        Позвоните нам по номеру <a href="tel:<?= SiteSettings::getValueByCode('phone_1'); ?>" class="phone_mask" style="color: #ff1a4a; font-weight: bold;"><?= SiteSettings::getValueByCode('phone_1'); ?></a> и мы быстро найдем ваш товар
    </p>
    <p style="text-align: center;margin: 20px 0; padding: 0 10px;">
        Или воспользуйтесь чатом в правом нижнем углу, мы отвечаем <span style="color: #ff1a4a; font-weight: bold; text-transform: uppercase;">моментально</span>
    </p>
    <img src="/upload/images/chat.png"/ style="width: auto; margin: auto auto;">
<?php endif; ?>