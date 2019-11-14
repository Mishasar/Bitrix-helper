<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}
?>
<div class="feature">
    <? foreach ($arResult as $item): ?>
        <div class="feature__item">
            <div class="feature__illuminate-wrap">
                <div class="feature__illuminate"></div>
            </div>
            <div class="feature__title"><?= $item['NAME'] ?></div>
        </div>
    <? endforeach; ?>
</div>
