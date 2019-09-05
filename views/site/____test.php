<?

use app\models\entity\Product;

?>
<form method="post" class="pricer">
    <div>
        <label>Наценка в %</label>
        <input name="percent" placeholder="Наценка в процентах" value="<?= $_POST['percent']; ?>">
    </div>
    <hr/>
    <div>
        <label>Скидка сайта</label>
        <input name="discount" placeholder="Скидка сайта"
               value="<?= (empty($_POST['discount'])) ? "15" : $_POST['discount']; ?>">
    </div>
    <input type="submit" name="calc" value="Посчитать">
    <input type="submit" name="refresh" value="Установить">
</form>
<? $products = Product::find(); ?>
<ul class="sales">
    <? /* @var $product Product */ ?>
    <? foreach ($products->all() as $product): ?>
        <li>
            <? if (Yii::$app->request->isPost): ?>
                <?
                $newPrice = floor($product->purchase + ($product->purchase * ($_POST['percent'] / 100)));
                $oldProfit = $product->price - $product->purchase;
                $oldProfitPercent = floor((($product->price / $product->purchase) - 1) * 100);

                $newProfit = $newPrice - $product->purchase;
                $newProfitPercent = floor((($newPrice / $product->purchase) - 1) * 100);
                $selfProfit = ($newPrice - (($newPrice * $_POST['discount'] / 100))) - $product->purchase;
                ?>
                <strong style="color: #FF1A4A;"><?= $product->name; ?></strong> Закуп: <?= $product->purchase; ?> / Цена: <?= $product->price; ?> / Выхлоп = <?= $oldProfit; ?> (<?= $oldProfitPercent ?>%) / Новая цена: <?= $newPrice; ?> / Выхлоп новой цены = <?= $newProfit; ?>(<?= $newProfitPercent; ?>%) /
                <strong style="color: green;">Выгода со
                    скидкой: <?= $selfProfit ?></strong>
            <? else: ?>
                Закуп: <?= $product->purchase; ?> / Цена: <?= $product->price; ?> / <?= $product->name; ?>
            <? endif; ?>
        </li>

        <?
        if (isset($_POST['refresh'])):
//            $product->scenario = Product::SCENARIO_UPDATE_PRODUCT;
//            $product->price = $product->purchase + (($product->purchase * $_POST['percent']) / 100);
//            $product->update();
        endif;
        ?>
    <? endforeach; ?>
</ul>
<style>
    .pricer {
    }

    .pricer div {
        margin: 2% 0;
        color: white;
    }

    .pricer div label {
        display: block;
    }

    .pricer div input {
        color: black;
    }

    .sales {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .sales li {
        color: white;
        margin: 1% 0;
    }
</style>