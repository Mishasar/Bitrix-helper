<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
} ?>
<? require_once(dirname(__FILE__) . '/../../include/templates/header.php'); ?>
<?$APPLICATION->IncludeComponent("bitrix:breadcrumb",".default",Array(
        "START_FROM" => "0",
        "PATH" => "",
        "SITE_ID" => "s1"
    )
);?>