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
<section class="section-title js-title">
    <div class="container">
        <h1 class="h1"><? $APPLICATION->ShowTitle() ?></h1>
    </div>
</section>
<section class="section about-top__section">
    <div class="container">
        <div class="about-top">
            <div class="about-top__img" style="background-image: url('<?=ASSETS_PATH?>img/about/about-image.jpg');"></div>
            <div class="about-top__content">