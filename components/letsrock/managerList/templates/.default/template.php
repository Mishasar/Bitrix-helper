<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}
?>
<div class="personal-card__list">
    <? foreach ($arResult as $item): ?>
        <? $APPLICATION->IncludeComponent("letsrock:manager", ".default", [
        'NAME' => $item['NAME'] . ' ' . $item['SECOND_NAME'] . ' ' . $item['LAST_NAME'],
        'POSITION' => $item['PROFESSION'],
        'IMAGE_ID' => $item['PHOTO'],
        'PHONE' => $item['PHONE'],
        'EMAIL' => $item['EMAIL']
    ]); ?>
    <? endforeach; ?>
</div>