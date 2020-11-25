<?php
/* @var $this yii\web\View */

use app\models\tool\seo\Title;
use app\modules\site_settings\models\entity\SiteSettings;
use yii\helpers\Url;
use app\widgets\Breadcrumbs;

$this->title = Title::showTitle("Наши контакты");

$this->params['breadcrumbs'][] = ['label' => 'Наши контакты', 'url' => Url::to(['site/contacts'])];
?>
<div class="page">
	<?= Breadcrumbs::widget([
		'homeLink' => [
			'label' => 'Главная ',
			'url' => Yii::$app->homeUrl,
			'title' => 'Первая страница сайта зоомагазина Котофей',
		],
		'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
	]); ?>
    <h1 class="page__title">Наши контакты</h1>
    <div class="d-flex flex-row justify-content-start w-100">
        <ul class="fa-ul w-50">
            <li>
                <span class="fa-li"><i class="fas fa-paw"></i></span>
                Email: <span><?= SiteSettings::getValueByCode('email'); ?></span>
            </li>
            <li>
                <span class="fa-li"><i class="fas fa-paw"></i></span>
                Email поддержки сайта: <span>support@kotofey.store</span>
            </li>
            <li>
                <span class="fa-li"><i class="fas fa-paw"></i></span>
                Телефон: <span class="js-phone-mask"><?= SiteSettings::getValueByCode('phone_1'); ?></span>
            </li>
            <li>
                <span class="fa-li"><i class="fas fa-paw"></i></span>
                Телефон: <span class="js-phone-mask"><?= SiteSettings::getValueByCode('phone_2'); ?></span>
            </li>
        </ul>
        <ul class="fa-ul w-50">
            <li>
                <span class="fa-li"><i class="fas fa-paw"></i></span>
                ИП Васин К.В.
            </li>
            <li>
                <span class="fa-li"><i class="fas fa-paw"></i></span>
                ИНН <span>222261129226</span>
            </li>
            <li>
                <span class="fa-li"><i class="fas fa-paw"></i></span>
                ОГРН <span>319222500105168</span>
            </li>
            <li>
                <span class="fa-li"><i class="fas fa-paw"></i></span>
                Юридический адрес <span>г.Барнаул, ул. Весенняя, д. 4.</span>
            </li>
            <li>
                <span class="fa-li"><i class="fas fa-paw"></i></span>
                Фактический адрес <span>г.Барнаул, ул. Северо-Западная, 6Б</span>
            </li>
        </ul>
    </div>
    <h2>Режим работы зоомагазина</h2>
    <p>Заявки на сайте принимаются круглосуточно.</p>
    <p>Доставка заказов производится с <strong>понедельника по пятницу</strong> в утренние часы с <strong>8.00 до 11.00</strong> и в вечернее время с <strong>19.00 до 23.00.</strong></p>

    <script type="text/javascript" charset="utf-8" async src="https://api-maps.yandex.ru/services/constructor/1.0/js/?um=constructor%3A75a2c08cf453a0309392fdcb243329f2301db73bdb97f18c8bc32cb9e14c1f93&amp;width=100%25&amp;height=400&amp;lang=ru_RU&amp;scroll=true"></script>

</div>

