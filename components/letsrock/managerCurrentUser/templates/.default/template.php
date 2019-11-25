<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}

if (empty($arResult)) {
    return '';
}
?>
<? $APPLICATION->IncludeComponent("letsrock:manager", ".default", [
    'NAME' => $arResult['NAME'] . ' ' . $arResult['SECOND_NAME'] . ' ' . $arResult['LAST_NAME'],
    'POSITION' => $arResult['PERSONAL_PROFESSION'],
    'IMAGE_ID' => $arResult['PERSONAL_PHOTO'],
    'PHONE' => $arResult['PERSONAL_PHONE'],
    'EMAIL' => $arResult['EMAIL']
]); ?>
