<?
/* @var $this yii\web\View */

use app\models\tool\seo\Title;
use app\models\entity\SiteSettings;

$this->title = Title::showTitle("Контакты");
?>

<h1 class="title">Контакты компании</h1>

<ul class="contacts-list">
    <li class="contacts-list__item">Email: <span><?= SiteSettings::getValueByCode('email'); ?></span></li>
    <li class="contacts-list__item">Email поддержки сайта: <span>support@kotofey.store</span></li>
    <li class="contacts-list__item">Телефон: <span class="phone_mask"><?= SiteSettings::getValueByCode('phone_1'); ?></span></li>
    <li class="contacts-list__item">Наш адрес: <span>Россия, Алтайский край, г. Барнаул</span></li>
</ul>

<script type="text/javascript" charset="utf-8" async src="https://api-maps.yandex.ru/services/constructor/1.0/js/?um=constructor%3A1f9b2285d3a2aa01708721bf43ba58cb3c9065d7c01e0ca9aa70d854fc3f5697&amp;width=100%25&amp;height=470&amp;lang=ru_RU&amp;scroll=true"></script>