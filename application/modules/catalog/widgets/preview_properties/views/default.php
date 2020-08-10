<?php
/* @var $properties array[] */
?>
<?php if ($properties): ?>
    <ul class="light-properties">
        <?php foreach ($properties as $label => $value): ?>
            <li class="light-properties__item">
                <div class="light-properties__label"><?= $label; ?></div>
                <div class="light-properties__value"><?= $value; ?></div>
            </li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>
