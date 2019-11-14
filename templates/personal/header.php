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
                <div class="personal-card" style="border: 1px solid red">
                    <div class="personal-card__head">
                        <div class="personal-card__avatar">
                            <img src="img/personal-card/personal-card.png" alt="Иванов Иван"></div>
                        <div class="personal-card__info">
                            <div class="personal-card__name">Иванов Иван</div>
                            <div class="personal-card__position">Ваш персональный менеджер</div>
                        </div>
                    </div>
                    <div class="personal-card__inner">
                        <div class="personal-card__row">
                            <div class="link-with-icon phone"><a class="link" href="tel:+79214950000">+7 (921) 495 00-00</a></div>
                        </div>
                        <div class="personal-card__row">
                            <div class="link-with-icon mail"><a class="link" href="mailto:examplemail@gmail.com">examplemail@gmail.com</a></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="content__box">