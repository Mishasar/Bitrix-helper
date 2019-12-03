<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
} ?>
<?
require_once(dirname(__FILE__) . '/../../include/templates/header.php');
?>
<?
    if(!$USER->IsAuthorized()) {
        LocalRedirect('/'); //Отправляем всех неавторизованных пользователей на домашнюю
    }
?>
<?$APPLICATION->IncludeComponent("bitrix:breadcrumb",".default",Array(
        "START_FROM" => "0",
        "PATH" => "",
        "SITE_ID" => "s1"
    )
);?>
<section class="section-title">
    <div class="container">
        <h1 class="h1">Личный кабинет</h1>
    </div>
</section>
<section class="section">
    <div class="container">
        <div class="content-sidebar cabinet__wrap">
            <div class="sidebar__box">
                <? $APPLICATION->IncludeComponent("bitrix:menu", "personal", [
                    "ALLOW_MULTI_SELECT" => "N",
                    "CHILD_MENU_TYPE" => "left",
                    "DELAY" => "N",
                    "MAX_LEVEL" => "1",
                    "MENU_CACHE_TIME" => "3600",
                    "MENU_CACHE_TYPE" => "N",
                    "MENU_CACHE_USE_GROUPS" => "Y",
                    "ROOT_MENU_TYPE" => "personal",
                    "USE_EXT" => "N",
                ],
                    false
                ); ?>
                <? $APPLICATION->IncludeComponent(
                        "letsrock:managerCurrentUser",
                        ".default",
                        []
                ); ?>
            </div>
            <div class="content__box">