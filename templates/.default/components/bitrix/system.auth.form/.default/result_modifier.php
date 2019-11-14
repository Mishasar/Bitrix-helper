<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

global $APPLICATION;

if (isset($_POST['AJAX-ACTION']) && $_POST['AJAX-ACTION'] == 'AUTH') {
    $APPLICATION->RestartBuffer();

    header('Content-type: application/json');

    if (
        (
            isset($arResult['ERROR'])
            && $arResult['ERROR'] === true
        )
        ||
        (
            !empty($arResult['ERROR_MESSAGE'])
            && isset($arResult['ERROR_MESSAGE']['TYPE'])
            && $arResult['ERROR_MESSAGE']['TYPE'] == 'ERROR'
        )
    ) {
        $response = [
            'STATUS' => 'ERROR',
            'MESSAGES' => [
                strip_tags($arResult['ERROR_MESSAGE']['MESSAGE'])
            ],
        ];
    } else {
        $response = [
            'STATUS' => 'OK',
        ];
    }

    echo \Bitrix\Main\Web\Json::encode($response);

    die();
}