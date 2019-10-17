<?
/* @var $this yii\web\View */
/* @var $providers \app\models\entity\Providers[] */
/* @var $news \app\models\entity\News[] */
use app\models\entity\SiteSettings;
use app\models\tool\seo\Title;
use app\widgets\order_custom_product\OrderCustomProduct;

$this->title = Title::showTitle("Главная страница");
?>
<div class="slider-index">
    <img src="/web/upload/images/sale.png">
</div>


<div class="edge">
    <ul>
        <li>
            <img src="https://image.flaticon.com/icons/svg/664/664468.svg">
            <p>Быстрая доставка</p>
        </li>
        <li>
            <img src="https://image.flaticon.com/icons/svg/1524/1524983.svg">
            <p>Удобные заказы</p>
        </li>
        <li>
            <img src="/web/upload/images/fire.png">
            <p>Популярные бренды</p>
        </li>
        <li>
            <img src="https://image.flaticon.com/icons/svg/45/45925.svg">
            <p>Широкий ассортимент</p>
        </li>
        <li>
            <img src="https://image.flaticon.com/icons/svg/1611/1611260.svg">
            <p>Низкие цены</p>
        </li>
    </ul>
</div>

<div class="test">
    <div class="index_about">
        <h2>Наши поставщики</h2>
        <ul>
		    <?php foreach ($providers as $provider): ?>
                <li><?php echo $provider->name; ?></li>
		    <?php endforeach; ?>
        </ul>
    </div>

    <div class="me-inst">
        <h2>Мы в Instagramm</h2>
        <a href="<?= SiteSettings::getValueByCode('insta_link'); ?>" rel="nofollow" target="_blank" ><img src="/web/upload/images/inst.png"></a>
        <div class="me-inst-block-link">
            <a href="<?= SiteSettings::getValueByCode('insta_link'); ?>" rel="nofollow" target="_blank" class="me-inst-link">Перейти</a>
        </div>
    </div>

    <div class="index-search">
        <h2>Новости</h2>
        <ul>
		    <?php foreach ($news as $new): ?>
                <li><?php echo $new->name; ?></li>
		    <?php endforeach; ?>
        </ul>
    </div>
</div>