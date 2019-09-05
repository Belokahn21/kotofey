<?
/* @var string $message */
?>
<div class="alert-notify-wrap">
    <div class="alert-notify error-notify">
        <span class="alert-notify__type"><i class="fas fa-check-circle"></i></span>
        <span class="alert-notify__close" onclick="this.parentElement.style.display='none';">&times;</span>
        <?= $message; ?>
    </div>
</div>
