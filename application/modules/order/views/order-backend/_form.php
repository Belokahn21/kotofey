<?php

use yii\helpers\ArrayHelper;

/* @var $users \app\models\entity\User[]
 * @var $model \app\modules\order\models\entity\Order
 * @var $deliveries \app\models\entity\Delivery[]
 * @var $payments \app\models\entity\Payment[]
 * @var $status \app\modules\order\models\entity\OrderStatus[]
 * @var $itemsModel \app\modules\order\models\entity\OrdersItems
 */

?>
<nav>
    <div class="nav nav-tabs" id="nav-tab" role="tablist">
        <?php if (!$model->isNewRecord): ?>
            <a class="nav-item nav-link<?= (!$model->isNewRecord ? ' active' : ''); ?>" id="nav-detail-info-edit-tab" data-toggle="tab" href="#nav-detail-info-edit" role="tab" aria-controls="nav-detail-info-edit" aria-selected="false">Общая инофрмация</a>
        <?php endif; ?>
        <a class="nav-item nav-link<?= ($model->isNewRecord ? ' active' : ''); ?>" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">Основное</a>
        <a class="nav-item nav-link" id="nav-items-edit-tab" data-toggle="tab" href="#nav-items-edit" role="tab" aria-controls="nav-items-edit" aria-selected="false">Товары в заказе</a>
    </div>
</nav>


<div class="tab-content" id="nav-tab-content-form">
    <?php if (!$model->isNewRecord): ?>
        <div class="tab-pane fade<?= ($model->isNewRecord ? '' : ' show active'); ?>" id="nav-detail-info-edit" role="tabpanel" aria-labelledby="nav-detail-info-edit-tab">
            <div class="d-flex flex-row">
                <div class="w-50">
                    <h4>Время и дата доставки</h4>
                    <?php try { ?>
                        <p><?= $model->dateDelivery->date; ?> - <?= $model->dateDelivery->time; ?></p>
                    <?php } catch (ErrorException $exception) { ?>
                        <p>Отстуствуют</p>
                    <?php } ?>

                    <h4>Адрес доставки</h4>
                    <?php try { ?>
                        <ul style="display: flex; flex-direction: row;">
                            <li style="margin: 0 5px;">Город <?= $model->owner->billing->city; ?></li>
                            <li style="margin: 0 5px;">Улица <?= $model->owner->billing->street; ?></li>
                            <li style="margin: 0 5px;">Дом <?= $model->owner->billing->home; ?></li>
                            <li style="margin: 0 5px;">Квртира <?= $model->owner->billing->house; ?></li>
                        </ul>
                    <?php } catch (ErrorException $exception) { ?>
                        <p>Отстуствуют</p>
                    <?php } ?>

                    <h4>Финансы</h4>
                    <p>Закуп: <?= \app\models\helpers\OrderHelper::orderPurchase($model->id); ?></p>
                    <p>Сумма заказа: <?= \app\models\helpers\OrderHelper::orderSummary($model->id); ?></p>

                    <h4>Место на карте</h4>

                    <?php

                    $address = "город {$model->owner->billing->city}, улица {$model->owner->billing->street}, дом {$model->owner->billing->home}";
                    $url = "https://geocode-maps.yandex.ru/1.x/?";
                    $params = [
                        'apikey' => Yii::$app->params['yandex']['geocode'],
                        'format' => 'json',
                        'geocode' => $address,
                    ];
                    $response = null;
                    $xyPoints = null;

                    $options = array(
                        "http" => array(
                            "header" => "User-Agent: Mozilla/5.0 (iPad; U; CPU OS 3_2 like Mac OS X; en-us) AppleWebKit/531.21.10 (KHTML, like Gecko) Version/4.0.4 Mobile/7B334b Safari/531.21.102011-10-16 20:23:10\r\n" // i.e. An iPad
                        )
                    );

                    $context = stream_context_create($options);
                    $response = file_get_contents($url . http_build_query($params), false, $context);

                    if ($response) {
                        $response = \yii\helpers\Json::decode($response);
                        $xyPoints = $response['response']['GeoObjectCollection']['featureMember'][0]['GeoObject']['Point']['pos'];
                    }

                    ?>

                    <div id="map" style="width: 600px; height: 400px"></div>

                    <script type="text/javascript">

                        ymaps.ready(init);

                        function init() {
                            // Создание карты.
                            var myMap = new ymaps.Map('map', {
                                    center: [<?=implode(',', array_reverse(explode(' ', $xyPoints)));?>],
                                    zoom: 17
                                }, {
                                    searchControlProvider: 'yandex#search'
                                }),

                                // Создаём макет содержимого.
                                MyIconContentLayout = ymaps.templateLayoutFactory.createClass(
                                    '<div style="color: #fff; font-weight: bold;">$[properties.iconContent]</div>'
                                ),

                                myPlacemark = new ymaps.Placemark(myMap.getCenter(), {
                                    hintContent: 'Собственный значок метки',
                                    balloonContent: 'Это красивая метка'
                                }, {
                                    // Опции.
                                    // Необходимо указать данный тип макета.
                                    // iconLayout: 'default#image',
                                    // Своё изображение иконки метки.
                                    // iconImageHref: 'images/myIcon.gif',
                                    // Размеры метки.
                                    // iconImageSize: [30, 42],
                                    // Смещение левого верхнего угла иконки относительно
                                    // её "ножки" (точки привязки).
                                    // iconImageOffset: [-5, -38]
                                });

                            myMap.geoObjects
                                .add(myPlacemark);
                        }
                    </script>
                </div>

                <div class="w-50">
                    <ul>
                        <?php foreach ($itemsModel as $item): ?>
                            <li class="d-flex flex-row justify-content-between align-items-center">
                                <?php if ($item->product): ?>
                                    <img class="w-25 m-5" src="/upload/<?= $item->product->image; ?>">
                                <?php endif; ?>

                                <div class="w-75">
                                    <?php if ($item->product): ?>
                                        <p><a href="<?= \yii\helpers\Url::to(['/admin/catalog', 'id' => $item->product->id]) ?>"><?= $item->name; ?></a></p>
                                    <?php else: ?>
                                        <p><?= $item->name; ?></p>
                                    <?php endif; ?>
                                    <?php if ($item->product): ?>
                                        <p>Внешний код: <?= $item->product->code; ?></p>
                                    <?php endif; ?>
                                    <?php if ($item->product): ?>
                                        <p>Зкупочная: <?= $item->product->purchase; ?></p>
                                    <?php endif; ?>
                                    <p>К продаже: <?= $item->price; ?></p>
                                    <p>Кол-во: <?= $item->count; ?></p>
                                </div>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <div class="tab-pane fade<?= ($model->isNewRecord ? ' show active' : ''); ?>" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
        <div class="d-flex flex-row">
            <div class="w-25 p-1"><?= $form->field($model, 'is_paid')->checkbox(); ?></div>
            <div class="w-25 p-1"><?= $form->field($model, 'is_cancel')->checkbox(); ?></div>
            <div class="w-25 p-1"><?= $form->field($model, 'is_close')->checkbox(); ?></div>
        </div>
        <div class="form-element">
            <div class="d-flex flex-row">
                <div class="w-25 p-1">
                    <?= $form->field($model, 'delivery_id')->dropDownList(ArrayHelper::map($deliveries, 'id', 'nameF'), [
                        'prompt' => 'Доставка'
                    ])->label(false); ?>
                </div>

                <div class="w-25 p-1">
                    <?= $form->field($model, 'payment_id')->dropDownList(ArrayHelper::map($payments, 'id', 'nameF'), [
                        'prompt' => 'Оплата'
                    ])->label(false); ?>
                </div>

                <div class="w-25 p-1">
                    <?= $form->field($model, 'status')->dropDownList(ArrayHelper::map($status, 'id', 'name'), [
                        'prompt' => 'Статус'
                    ])->label(false); ?>
                </div>

                <div class="w-25 p-1">
                    <?= $form->field($model, 'user_id')->dropDownList(ArrayHelper::map($users, 'id', 'email'), [
                        'prompt' => 'Покупатель'
                    ])->label(false); ?>
                </div>
            </div>
        </div>

        <div class="form-element">
            <div class="d-flex flex-row">
                <div class="w-50 p-1">
                    <?= $form->field($model, 'notes')->textarea(['rows' => 10]); ?>
                </div>
                <div class="w-50 p-1">
                    <?= $form->field($model, 'comment')->textarea(['rows' => 10]); ?>
                </div>
            </div>
        </div>
    </div>
    <div class="tab-pane fade" id="nav-items-edit" role="tabpanel" aria-labelledby="nav-items-edit-tab">
        <?php if ($model->isNewRecord): ?>
            <?= $this->render('include/new_items', [
                'itemsModel' => $itemsModel,
                'form' => $form
            ]); ?>
        <?php else: ?>
            <?= $this->render('include/update_items', [
                'itemsModel' => $itemsModel,
                'form' => $form
            ]); ?>
        <?php endif; ?>

    </div>
</div>