<?php
/* @var string $message */
/* @var string $flag */
?>

<div class="alert-notify-wrap">
    <div class="alert-notify <?= $flag; ?>-notify">
        <span class="alert-notify__type"><i class="fas fa-check-circle"></i></span>
        <span class="alert-notify__text"><?= $message; ?></span>
        <span class="alert-notify__close" onclick="this.parentElement.style.maxHeight='0'; setTimeout(()=>{},1000)">&times;</span>
    </div>
</div>
