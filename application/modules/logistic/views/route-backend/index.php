<?php

use app\modules\site\models\tools\PriceTool;
use app\modules\site\models\tools\Currency;
use yii\helpers\Html;
use app\modules\seo\models\tools\Title;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use app\modules\catalog\models\entity\Product;
use app\modules\order\models\helpers\OrderHelper;

/* @var $models \app\modules\order\models\entity\Order[]
 * @var $model \app\modules\logistic\models\forms\LogisticForm
 */

$this->title = Title::show("Список доставок");
?>
    <div class="title-group">
        <h1>Список доставок</h1>
    </div>

<?php if ($models): ?>
    <div class="logistic-list">
        <?php foreach ($models as $order): ?>
            <?php $order_summary = OrderHelper::orderSummary($order); ?>
            <div class="card m-1">
                <div class="card-body">
                    <div class="row">
                        <div class="col-5"><h5 class="card-title">Заказ #<?= $order->id; ?></h5></div>
                        <div class="col-7">
                            <?php if ($order->is_paid): ?>
                                [<span class="green">Оплачено</span>]
                            <?php else: ?>
                                [<span class="red">Не оплачено</span>]
                            <?php endif; ?>
                        </div>
                        <div></div>
                    </div>
                    <div class="row">
                        <div class="col-12">

                            <div class="row my-1">
                                <div class="col-5 bold">Сумма заказа:</div>
                                <div class="col-7"><?= PriceTool::format($order_summary); ?> <?= Currency::getInstance()->show(); ?></div>
                            </div>
                            <div class="row my-1">
                                <div class="col-5 bold">Статус:</div>
                                <div class="col-7"><?= OrderHelper::getStatus($order); ?></div>
                            </div>
                            <?php if ($order->odd): ?>
                                <div class="row my-1">
                                    <div class="col-5 bold">Сдача</div>
                                    <div class="col-7"><?= PriceTool::format($order->odd - $order_summary); ?></div>
                                </div>
                            <?php endif; ?>
                            <div class="row my-1">
                                <div class="col-5 bold">Оплата:</div>
                                <div class="col-7"><?= OrderHelper::getPayment($order); ?></div>
                            </div>
                            <div class="row my-1">
                                <div class="col-5 bold">Телефон:</div>
                                <div class="col-7"><?= $order->phone; ?></div>
                            </div>
                            <div class="row my-1">
                                <div class="col-5 bold">Email:</div>
                                <div class="col-7"><?= $order->email; ?></div>
                            </div>
                            <div class="row my-1">
                                <div class="col-5 bold">Дата/Время доставки:</div>
                                <div class="col-7"><?= $order->dateDelivery->date; ?>/<?= $order->dateDelivery->time; ?></div>
                            </div>
                            <div class="row my-1">
                                <div class="col-12 bold">Адрес доставки:</div>
                                <div class="col-12">
                                    <?= !$order->city ? '' : 'г.' . $order->city; ?>
                                    <?= !$order->street ? '' : ' , ул.' . $order->street; ?>
                                    <?= !$order->number_home ? '' : ', дом ' . $order->number_home; ?>
                                    <?= !$order->entrance ? '' : ', п. ' . $order->entrance; ?>
                                    <?= !$order->number_appartament ? '' : ', кв. ' . $order->number_appartament; ?>
                                    <?= !$order->floor_house ? '' : ', эт. ' . $order->floor_house; ?>
                                </div>
                            </div>
                            <?php if ($order->notes): ?>
                                <div class="row my-1">
                                    <div class="col-5 bold">Заметки админов:</div>
                                    <div class="col-7">
                                        <?= $order->notes; ?>
                                    </div>
                                </div>
                            <?php endif; ?>

                            <?php if ($order->comment): ?>
                                <div class="row my-1">
                                    <div class="col-5 bold">Комментарий заказа:</div>
                                    <div class="col-7">
                                        <?= $order->comment; ?>
                                    </div>
                                </div>
                            <?php endif; ?>

                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-12">
                            <div class="row">
                                <div class="col-4"><a href="tel:<?= $order->phone; ?>" type="button" class="btn btn-info"><i class="fas fa-phone"></i></a></div>
                                <div class="col-4"><a href="<?= Url::to(['/admin/order/order-backend/update', 'id' => $order->id]); ?>" type="button" class="btn btn-info"><i class="fas fa-clipboard-list"></i></a></div>
                                <div class="col-4"><a href="tel:<?= $order->phone; ?>" type="button" class="btn btn-info"><i class="fas fa-map-marker-alt"></i></a></div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <?php if (!$order->is_close): ?>
                                <?php $form = ActiveForm::begin(); ?>
                                <?= $form->field($model, 'order_id')->hiddenInput(['value' => $order->id])->label(false) ?>
                                <?= Html::submitButton('Завершить заказ', ['class' => 'btn btn-success w-100', 'onClick' => 'return confirm();']) ?>
                                <?php ActiveForm::end(); ?>
                            <?php endif; ?>
                        </div>
                    </div>


                    <div class="mt-3">
                        <a class="card-link" data-toggle="collapse" href="#list_items-<?= $order->id; ?>" role="button" aria-expanded="false" aria-controls="list_items-<?= $order->id; ?>">
                            Список товаров в заказе
                        </a>
                        <div class="collapse" id="list_items-<?= $order->id; ?>">
                            <div class="card card-body">
                                <ul class="list-group list-group-flush">
                                    <?php foreach ($order->items as $item): ?>
                                        <?php if ($item->product instanceof Product): ?>
                                            <li class="list-group-item">
                                                <?= $item->count; ?>шт. x <?= PriceTool::format($item->price); ?>(<?= PriceTool::format($item->purchase); ?>) <?= Currency::getInstance()->show(); ?>
                                                <a href="<?= Url::to(['/admin/catalog/product-backend/update', 'id' => $item->product->id]) ?>">
                                                    <?= $item->product->name; ?>
                                                </a>
                                            </li>
                                        <?php else: ?>
                                            <li class="list-group-item"><?= $item->name; ?></li>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>