<?php

use app\modules\seo\models\tools\Title;
use app\modules\vacancy\models\helpers\VacancyHelper;

/* @var $models \app\modules\vacancy\models\entity\Vacancy[] */

$this->title = Title::show('Вакансии');
?>
<h1>Вакансии</h1>
<?php if ($models): ?>
    <ul class="vacancy-list">
        <?php foreach ($models as $item): ?>
            <li class="vacancy-list__item">
                <?php if ($item->image): ?>
                    <img class="vacancy-list__image" src="/upload/<?= $item->image; ?>" alt="<?= $item->title; ?>" title="<?= $item->title; ?>">
                <?php else: ?>
                    <img class="vacancy-list__image" src="/upload/images/vacancy.jpg" alt="<?= $item->title; ?>" title="<?= $item->title; ?>">
                <?php endif; ?>
                <div class="vacancy-list__title"><?= $item->title; ?></div>
                <div class="vacancy-list__price"><?= $item->price; ?></div>
                <div class="vacancy-list__description"><?= $item->description; ?></div>
                <a class="vacancy-list__callback btn-main" href="<?= VacancyHelper::getDetailUrl($item); ?>">Подробнее</a>
            </li>
        <?php endforeach; ?>
    </ul>
<?php else: ?>
    <strong>Вакансии отстуствуют. Загляните к нам позже!, но если считаете, что ваша кандидатура очень сильна нам нужна, то отправьте своё резюме на <a href="mailto:<?= Yii::$app->params['email']['job']; ?>">электронный адрес</a></strong>
<?php endif; ?>
