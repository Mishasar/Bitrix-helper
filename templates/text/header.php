<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
} ?>
<?
require_once(dirname(__FILE__) . '/../../include/templates/header.php');
?>
<?$APPLICATION->IncludeComponent("bitrix:breadcrumb",".default",Array(
        "START_FROM" => "0",
        "PATH" => "",
        "SITE_ID" => "s1"
    )
);?>
<section class="section-title">
    <div class="container">
        <h1 class="h1">Контакты</h1>
    </div>
</section>
<section class="section">
    <div class="container">
