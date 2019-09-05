<?

use app\models\tool\delivery\calc\Dellin;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use app\models\tool\delivery\calc\CalculateDelllin;

?>

<?
$dellin = new Dellin();

$calucate = new CalculateDelllin();
$calucate->setSessionID($dellin->getSessionID());

$info = $calucate->calc($_GET['filter']);

//echo "<pre>";
//print_r($info);
//print_r($info['derival']['terminals']);
//echo "</pre>";
?>
<form method="get" class="geoData" action="/test/">
    <div>
        <input type="text" name="position" class="geoData_pos">
        <div class="response"></div>
        <input type="hidden" name="filter[derivalPoint]" class="geoData_code">
    </div>

    <button type="submit">Поиск</button>
</form>
<?= Html::beginTag("div", ['class' => 'calc-delline']); ?>
    <?= Html::beginForm('/test/', 'GET', []); ?>

        <?= Html::beginTag('div', ['class' => 'calc-delline__input']) ?>
            <?= Html::label('Обем груза, м3'); ?>
            <?= Html::input('text', 'params[sizedVolume]', Yii::$app->request->get('params')['sizedVolume']); ?>
        <?= Html::endTag('div') ?>

        <?= Html::beginTag('div', ['class' => 'calc-delline__input']) ?>
            <?= Html::label('Общий вес груза, кг'); ?>
            <?= Html::input('text', 'params[sizedWeight]', Yii::$app->request->get('params')['sizedWeight']); ?>
        <?= Html::endTag('div') ?>

        <?= Html::submitButton("Расчёт", ['class'=>'calc-delline__submit']); ?>
    <?= Html::endForm(); ?>
<?= Html::endTag("div"); ?>


<? if ($info): ?>
    <div class="summary">
        <h2 class="summary__title">Исходная информация</h2>
        <table class="summary__info">
            <tr>
                <td>Цена</td>
                <td><?= $info['derival']['price'] ?></td>
            </tr>
            <tr>
                <td>Скидка</td>
                <td><?= $info['derival']['discount'] ?></td>
            </tr>
            <tr>
                <td>Время доставки</td>
                <td><?= $info['time']['nominative']; ?></td>
            </tr>
        </table>
        <form method="get" action="/test/">
            <div class="summary__item">
                <label>Точка отправки</label>
                <select name="outPoint" class="summary__outPoint">
                    <? if (isset($info['derival']['terminals'])): ?>
                        <? foreach ($info['derival']['terminals'] as $point): ?>
                            <option value="<?= $point['id'] ?>">[<?= $point['id'] ?>] <?= $point['address'] ?></option>
                        <? endforeach; ?>
                    <? endif; ?>
                </select>
            </div>
        <h2 class="summary__title">Точка прибытия</h2>
        <table class="summary__info">
            <tr>
                <td>Город прибытия</td>
                <td><?= $info['arrival']['city'] ?></td>
            </tr>
        </table>

            <div>
                <label>Точка прибытия</label>
                <select name="outPoint" class="summary__outPoint">
                    <? if (isset($info['arrival']['terminals'])): ?>
                        <? foreach ($info['arrival']['terminals'] as $point): ?>
                            <option value="<?= $point['id'] ?>">[<?= $point['id'] ?>] <?= $point['address'] ?></option>
                        <? endforeach; ?>
                    <? endif; ?>
                </select>
            </div>
        </form>
    </div>
<? endif; ?>



<style>
    .calc-delline{color: white;}
        .calc-delline__input{margin: 1% 0; color: black;}
        /*.calc-delline__input input{}*/
        .calc-delline label{display: block; color: white;}
    .calc-delline__submit{color: white; background: #FF1A4A; padding: 0.5% 1.5%; border: 1px red solid; -webkit-border-radius: 0.3em; -moz-border-radius: 0.3em; border-radius: 0.3em; margin: 1% 0;}

    .summary{border: 1px red solid; border-radius: 0.5em; padding: 1%;}
        .summary__title{color: white; padding: 0; margin: 0;}
        .summary label{display: block; color: white;}
        .summary__outPoint{padding: 0.5% 0.1%; border-radius: 0.3em; border: 1px #ddd solid;}
        .summary__info{color: white; margin: 1% 0; width: 400px; border-top: 1px #ddd solid; border-bottom: 1px #ddd solid; text-align: center;}
        .summary__item{margin: 1% 0;}


    .response{color: white; margin: 2% 0; padding: 1%;}
</style>


