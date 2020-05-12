<?php

use yii\helpers\StringHelper;
use app\models\tool\Backup;
use app\models\tool\Currency;
use app\models\tool\Price;
use app\models\tool\seo\Title;
use app\modules\order\models\entity\Order;
use app\widgets\todo\ToDoWidget;
use app\models\entity\User;
use app\models\entity\SearchQuery;
use app\models\tool\statistic\OrderStatistic;
use app\models\tool\statistic\ProductStatistic;
use app\models\entity\ProductSync;

/* @var $this yii\web\View
 * @var $last_search \app\models\entity\SearchQuery[]
 */

$this->title = Title::showTitle("Главная страница");
?>
<?= $this->render('modal/search', [
	'last_search' => SearchQuery::find()->orderBy(['created_at' => SORT_DESC])->all()
]); ?>
<?= $this->render('modal/order-stat'); ?>
<section class="desktop">
    <h1 class="title">Рабочий стол</h1>
    <div class="block-info-wrap">
        <ul class="block-info__list">
            <li class="block-info__item">
                <div class="item-wrap">
                    <div class="block-info__icon interactive" data-toggle="modal" data-target="#show-order-stat">
                        <i class="fas fa-cash-register"></i>
                    </div>
                    <div class="block-info__content">
                        <ul class="statistic__list">
                            <li class="statistic__item">
                                <div class="statistic__item-key">Всего заказов</div>
                                <div class="statistic__item-value"><?= Order::find()->count(); ?></div>
                            </li>
                            <li class="statistic__item">
                                <div class="statistic__item-key">Оборот</div>
                                <div class="statistic__item-value"><?= Price::format(OrderStatistic::income()); ?></div>
                            </li>
                            <li class="statistic__item">
                                <div class="statistic__item-key">Выручка</div>
                                <div class="statistic__item-value"><?= Price::format(OrderStatistic::marginality()); ?></div>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="block-info__summary">900/+9000</div>
            </li>

            <li class="block-info__item">
                <div class="item-wrap">
                    <div class="block-info__icon">
                        <i class="fas fa-gifts"></i>
                    </div>
                    <div class="block-info__content">
                        <ul class="statistic__list">
                            <li class="statistic__item">
                                <div class="statistic__item-key">Всего товарв</div>
                                <div class="statistic__item-value"><?= ProductStatistic::countAllProducts(); ?></div>
                            </li>
                            <li class="statistic__item">
                                <div class="statistic__item-key">Доход</div>
                                <div class="statistic__item-value"><?= Price::format(ProductStatistic::income()); ?><?= Currency::getInstance()->show(); ?></div>
                            </li>
                            <li class="statistic__item">
                                <div class="statistic__item-key">Общая сумма</div>
                                <div class="statistic__item-value"><?= Price::format(ProductStatistic::countPurchase()); ?><?= Currency::getInstance()->show(); ?></div>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="block-info__summary"><?= ProductSync::find()->count(); ?>/+9000</div>
            </li>

            <li class="block-info__item">
                <div class="item-wrap">
                    <div class="block-info__icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <div class="block-info__content">
                        <ul class="statistic__list">
                            <li class="statistic__item">
                                <div class="statistic__item-key">Всего пользователей</div>
                                <div class="statistic__item-value"><?= User::find()->count(); ?></div>
                            </li>
                            <li class="statistic__item">
                                <div class="statistic__item-key">В сети</div>
                                <div class="statistic__item-value">0</div>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="block-info__summary">900/+9000</div>
            </li>

            <li class="block-info__item">
                <div class="item-wrap">
                    <div class="block-info__icon interactive" data-toggle="modal" data-target="#show-search-stat">
                        <i class="fas fa-search"></i>
                    </div>
                    <div class="block-info__content">
						<?php if ($last_search): ?>
                            <ul class="statistic__list">
								<?php foreach ($last_search as $phrase): ?>
                                    <li class="statistic__item" data-toggle="tooltip" data-placement="bottom" title="<?= $phrase->text; ?>">
										<?= StringHelper::truncate($phrase->text, 15, '...'); ?>
                                    </li>
								<?php endforeach; ?>
                            </ul>
						<?php endif; ?>
                    </div>
                </div>

                <div class="block-info__summary">900/+9000</div>
            </li>

            <li class="block-info__item">
                <div class="item-wrap">
                    <div class="block-info__icon interactive">
                        <a href="/admin/?save_dump=Y" class="link-dump">
                            <i class="fas fa-sync-alt"></i>
                        </a>
                    </div>
                    <div class="block-info__content">
                        Копия базы данных
                        <input type="checkbox" name="out_file" class="out-file-handler">Скачать
                    </div>
                </div>

                <div class="block-info__summary">Последняя копия: <?= date('d.m.Y', Backup::getInstance()->getFileDate()); ?></div>
            </li>
        </ul>
    </div>
	<?= ToDoWidget::widget(); ?>
</section>

<script type="text/javascript">
	var element = document.querySelector('.out-file-handler');
	var link = document.querySelector('.link-dump');

	element.addEventListener('click', function () {

		if (element.checked) {
			link.setAttribute('href', '/admin/?save_dump=Y&out=Y');
		} else {
			link.setAttribute('href', '/admin/?save_dump=Y');
		}

	});
</script>