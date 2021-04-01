<?php
/* @var $this yii\web\View */

use app\modules\seo\models\tools\Title;
use app\modules\site_settings\models\entity\SiteSettings;
use yii\helpers\Url;
use app\widgets\Breadcrumbs;

$this->title = Title::show("Наши контакты");

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
                Email: <a href="mailto:<?= SiteSettings::getValueByCode('email'); ?>"><?= SiteSettings::getValueByCode('email'); ?></a>
            </li>
            <li>
                <span class="fa-li"><i class="fas fa-paw"></i></span>
                Email поддержки сайта: <a href="mailto:support@kotofey.store">support@kotofey.store</a>
            </li>
            <li>
                <span class="fa-li"><i class="fas fa-paw"></i></span>
                Телефон: <a href="tel:<?= SiteSettings::getValueByCode('phone_1'); ?>" class="js-phone-mask"><?= SiteSettings::getValueByCode('phone_1'); ?></a>
            </li>
        </ul>
        <ul class="fa-ul w-50">
            <li>
                <span class="fa-li"><i class="fas fa-paw"></i></span>
                ООО "Интернет-Зоомагазин Котофей"
            </li>
            <li>
                <span class="fa-li"><i class="fas fa-paw"></i></span>
                ИНН <span>2222889641</span>
            </li>
            <li>
                <span class="fa-li"><i class="fas fa-paw"></i></span>
                ОГРН <span>1212200000022</span>
            </li>
            <li>
                <span class="fa-li"><i class="fas fa-paw"></i></span>
                Юридический адрес <span>656922, Алтайский край, г. Барнаул, Весенняя ул., д. 4, кв. 55</span>
            </li>
            <li>
                <span class="fa-li"><i class="fas fa-paw"></i></span>
                Фактический адрес <span>г.Барнаул, ул. Северо-Западная, 6Б</span>
            </li>
        </ul>
    </div>
</div>

