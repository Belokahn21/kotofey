<?

use app\widgets\calc_porduct_delivery\assets\classes\DeliveryCalcAsset;



DeliveryCalcAsset::register($this);
?>
<div class="delivery-calc-wrap">
    <form method="POST">
        <div class="elem-form">

            <select name="delivery" class="delivery-calc-select-tk">
                <option>Выбрать транспортную компанию</option>
                <option value="dellin">Деловые линии</option>
                <option value="dellin">Пэк</option>
            </select>

        </div>

        <div class="elem-form">

            <input type="text" class="delivery-calc-select-out-city" name="out_point" placeholder="Город отправки" value="Барнаул" readonly/>

        </div>

        <div class="elem-form">

            <input type="text" class="delivery-calc-select-in-city" name="out_point" placeholder="Город доставки"/>

        </div>
    </form>
</div>
