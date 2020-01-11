<?php
/* @var $product_id integer */
?>
<div class="modal fade" id="buy-as-weight" tabindex="-1" role="dialog" aria-labelledby="buy-as-weightLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="buy-as-weightLabel">Купить на разнавес</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-6 select-weight">
                        <h2>Укажите нужный вес</h2>
                        <form class="select-weight-form">
                            <input placeholder="0" class="select-weight-form__amount"><span> г</span>
                            <input type="hidden" class="select-weight-form__product-id" value="<?= $product_id; ?>">
                        </form>
                    </div>
                    <div class="col-sm-6 select-packaging">
                        <h2>Выбор упаковки</h2>
                        <ul class="packaging-list">
                            <li class="packaging-list__item">
                                <img class="packaging-list__image" src="/web/upload/images/eco.jpg">
                                <div class="packaging-list__title">Эко-упаковка (+70р)</div>
                            </li>
                            <li class="packaging-list__item">
                                <img class="packaging-list__image" src="/web/upload/images/plastic.jpeg">
                                <div class="packaging-list__title">Обычный пакет (+0р)</div>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12 buy-weight__summary">
                        К оплате: <span class="buy-weight__price">0</span> р
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Отменить</button>
                <button type="button" class="btn btn-main">Добавить в корзину</button>
            </div>
        </div>
    </div>
</div>