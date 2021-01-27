<?php
/* @var $message string */
?>
<div class="not-available-search">
    <?= $message; ?>
    <div onclick="document.querySelector('.not-available-search').remove();" class="not-available-search__close">X</div>
</div>

<style type="text/css">
    .not-available-search {
        background: red;
        color: white;
        padding: 15px;
        margin: 10px 0;
        border-radius: 7px;
        font-weight: bold;
        position: relative;
        cursor: pointer;
    }

    .not-available-search__close {
        position: absolute;
        right: 0;
        top: 0;
        background: white;
        color: black;
        width: 20px;
        height: 20px;
        font-size: 14px;
        line-height: 18px;
        text-align: center;
        border: 1px rgba(0, 0, 0, 0.5) solid;
        border-radius: 50%;
    }
</style>