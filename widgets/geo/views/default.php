<?php
use yii\bootstrap\Modal;
?>

<div class="current-city">
    Ваш город: <span data-toggle="modal" data-target="#exampleModal">Барнаул</span>
</div>
<?php Modal::begin([
	'header' => '<h4>Выбрать город</h4>',
	'id' => 'exampleModal',
	'size' => 'modal-lg',
]); ?>
<ul class="city-list">
	<?php foreach ($cities as $city): ?>
        <li><a href=""><?= $city->name; ?></a></li>
	<?php endforeach ?>
</ul>
<?php Modal::end(); ?>