<?php
/* @var $delivery_times array */
?>
<?php if ($delivery_times): ?>
    <ul class="order-time">
        <?php foreach ($delivery_times as $key => $time): ?>
            <li data-value="с <?= $key; ?>.00 до <?= $time; ?>.00" class="order-time__item">с <?= $key; ?>.00 до <?= $time; ?>.00</li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>