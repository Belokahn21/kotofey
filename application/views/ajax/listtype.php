<?php /* @var $item \app\modules\catalog\models\entity\SaveInformersValues */ ?>
<option>Тип корма</option>
<?php foreach ($items as $item): ?>
    <option value="<?php echo $item->id; ?>"><?php echo $item->value; ?></option>
<?php endforeach; ?>

