<?

use app\models\tool\seo\Title;
use app\models\entity\Product;
use app\models\entity\Order;
use app\widgets\todo\ToDoWidget;
use app\models\entity\User;
use app\models\entity\SearchQuery;

/* @var $this yii\web\View
 * @var $last_search \app\models\entity\SearchQuery[]
 */

$this->title = Title::showTitle("Главная страница");
?>
<?= $this->render('modal/search', [
	'last_search' => SearchQuery::find()->orderBy(['created_at' => SORT_DESC])->all()
]); ?>
<section class="desktop">
    <h1 class="title">Рабочий стол</h1>
    <div class="block-info-wrap">
        <ul class="block-info__list">
            <li class="block-info__item">
                <div class="item-wrap">
                    <div class="block-info__icon">
                        <i class="fas fa-cash-register"></i>
                    </div>
                    <div class="block-info__content">
                        <ul class="statistic__list">
                            <li class="statistic__item">
                                <div class="statistic__item-key">Всего заказов</div>
                                <div class="statistic__item-value"><?= Order::find()->count(); ?></div>
                            </li>
                            <li class="statistic__item">
                                <div class="statistic__item-key">Выручка</div>
                                <div class="statistic__item-value">+525</div>
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
                                <div class="statistic__item-value"><?= Product::find()->count(); ?></div>
                            </li>
                            <li class="statistic__item">
                                <div class="statistic__item-key">Доход</div>
                                <div class="statistic__item-value">+700</div>
                            </li>
                            <li class="statistic__item">
                                <div class="statistic__item-key">Общая сумма</div>
                                <div class="statistic__item-value">+9700</div>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="block-info__summary">900/+9000</div>
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
                    <div class="block-info__icon" data-toggle="modal" data-target="#show-search-stat">
                        <i class="fas fa-search"></i>
                    </div>
                    <div class="block-info__content">
						<?php if ($last_search): ?>
                            <ul class="statistic__list">
								<?php foreach ($last_search as $phrase): ?>
                                    <li class="statistic__item">
										<?= $phrase->text; ?>
                                    </li>
								<?php endforeach; ?>
                            </ul>
						<?php endif; ?>
                    </div>
                </div>

                <div class="block-info__summary">900/+9000</div>
            </li>
        </ul>
    </div>
	<?= ToDoWidget::widget(); ?>
</section>