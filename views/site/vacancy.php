<?php

use app\models\tool\seo\Title;

/* @var $items \app\models\entity\Vacancy[] */

$this->title = Title::showTitle('Вакансии');
?>
<h1>Вакансии</h1>
<?php if ($items): ?>
    <ul class="vacancy">
		<?php foreach ($items as $item): ?>
            <li class="vacancy__item">
				<?php if ($item->image): ?>
                    <img class="vacancy__image" src="/web/upload/<?= $item->image; ?>" alt="<?= $item->title; ?>" title="<?= $item->title; ?>">
				<?php else: ?>
                    <img class="vacancy__image" src="/web/upload/images/search.png" alt="<?= $item->title; ?>" title="<?= $item->title; ?>">
				<?php endif; ?>
                <div class="vacancy__title"><?= $item->title; ?></div>
                <div class="vacancy__price"><?= $item->price; ?></div>
                <a class="vacancy__link" href="/vacancy/<?= $item->slug; ?>/">Подробнее</a>
            </li>
		<?php endforeach; ?>
    </ul>
<?php else: ?>
<strong>Вакансии отстуствуют. Загляните к нам позже!</strong>
<?php endif; ?>
