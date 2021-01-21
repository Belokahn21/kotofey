<?php
/* @var $values \app\modules\catalog\models\entity\PropertiesProductValues[] */
?>

<?php foreach ($values as $value): ?>
    <?= $value->property->name; ?>
<?php endforeach; ?>