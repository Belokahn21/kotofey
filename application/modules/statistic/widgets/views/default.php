<?php
/* @var $lastSearch \app\modules\search\models\entity\SearchQuery[]
 * @var $searches \app\modules\search\models\entity\SearchQuery[]
 * @var $this \yii\web\View
 */

use app\modules\catalog\models\entity\Product;
use app\modules\order\models\entity\Order;

?>
    <div class="statistic">
        <div class="statistic__item">
            <div class="statistic__icon"><i class="fas fa-cookie"></i></div>
            <div class="statistic__content">
                <div class="statistic-info">
                    <div class="statistic-info__item">
                        <div class="statistic-info__key">Последний бэкап</div>
                        <div class="statistic-info__value">17.08.2020</div>
                    </div>
                    <div class="statistic-info__item">
                        <div class="statistic-info__key">Сделать бэкап</div>
                        <div class="statistic-info__value">
                            <button class="statistic-action" type="button">Начать</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="statistic__item">
            <div class="statistic__icon"><i class="fas fa-cookie"></i></div>
            <div class="statistic__content">
                <div class="statistic-info">
                    <div class="statistic-info__item">
                        <div class="statistic-info__key">Заказов</div>
                        <div class="statistic-info__value"><?= Order::find()->count(); ?></div>
                    </div>
                    <div class="statistic-info__item">
                        <div class="statistic-info__key">Прибыль</div>
                        <div class="statistic-info__value">39 569 Р</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="statistic__item">
            <div class="statistic__icon"><i class="fas fa-cookie"></i></div>
            <div class="statistic__content">
                <div class="statistic-info">
                    <div class="statistic-info__item">
                        <div class="statistic-info__key">Товаров</div>
                        <div class="statistic-info__value"><?= Product::find()->count(); ?></div>
                    </div>
                    <div class="statistic-info__item">
                        <div class="statistic-info__key">Прибыль</div>
                        <div class="statistic-info__value">3 569 Р</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="statistic__item">
            <div class="statistic__icon" data-toggle="modal" data-target="#search-list"><i class="fas fa-search"></i></div>
            <div class="statistic__content">
				<?php if ($lastSearch): ?>
                    <div class="last-search">
						<?php foreach ($lastSearch as $search): ?>
                            <div class="last-search__item"><?= $search->text; ?></div>
						<?php endforeach; ?>
                    </div>
				<?php endif; ?>
            </div>
        </div>
    </div>

<?= $this->render('include/modal-last-search', [
	'searches' => $searches
]); ?>