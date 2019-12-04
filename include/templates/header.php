<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <?
    use Bitrix\Main\Page\Asset;

    CUtil::InitJSCore();
    CJSCore::Init(['fx', 'ajax', 'json', 'ls', 'session', 'jquery', 'popup', 'pull']);

    Asset::getInstance()->addString('<link rel="shortcut icon" href="' . ASSETS_PATH . 'img/favicons/favicon.ico" type="image/x-icon">');
    Asset::getInstance()->addString('<link rel="apple-touch-icon" href="' . ASSETS_PATH . 'img/favicons/apple-touch-icon.png">');
    Asset::getInstance()->addString('<link rel="apple-touch-icon" sizes="57x57" href="' . ASSETS_PATH . 'img/favicons/apple-touch-icon-57x57.png">');
    Asset::getInstance()->addString('<link rel="apple-touch-icon" sizes="72x72" href="' . ASSETS_PATH . 'img/favicons/apple-touch-icon-72x72.png">');
    Asset::getInstance()->addString('<link rel="apple-touch-icon" sizes="76x76" href="' . ASSETS_PATH . 'img/favicons/apple-touch-icon-76x76.png">');
    Asset::getInstance()->addString('<link rel="apple-touch-icon" sizes="114x114" href="' . ASSETS_PATH . 'img/favicons/apple-touch-icon-114x114.png">');
    Asset::getInstance()->addString('<link rel="apple-touch-icon" sizes="120x120" href="' . ASSETS_PATH . 'img/favicons/apple-touch-icon-120x120.png">');
    Asset::getInstance()->addString('<link rel="apple-touch-icon" sizes="144x144" href="' . ASSETS_PATH . 'img/favicons/apple-touch-icon-144x144.png">');
    Asset::getInstance()->addString('<link rel="apple-touch-icon" sizes="152x152" href="' . ASSETS_PATH . 'img/favicons/apple-touch-icon-152x152.png">');
    Asset::getInstance()->addString('<link rel="apple-touch-icon" sizes="180x180" href="' . ASSETS_PATH . 'img/favicons/apple-touch-icon-180x180.png">');
    //Подключаем статику
    Asset::getInstance()->addCss(ASSETS_PATH . "styles/main.min.css");
    Asset::getInstance()->addJs(ASSETS_PATH . "js/main.min.js");
    Asset::getInstance()->addJs("https://api-maps.yandex.ru/2.1/?lang=ru_RU");
    ?>
    <? $APPLICATION->ShowHead(); ?>
    <title><? $APPLICATION->ShowTitle(false)?></title>
    <meta name="theme-color" content="#c9e0e04d">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
</head>
<body>
<? $APPLICATION->ShowPanel() ?>
<div class="wrapper js-wrapper">
    <main class="main-gradient">
        <header class="header js-mobile-menu">
            <div class="header__top">
                <div class="container">
                    <div class="header__top-inner">
                        <div class="header__mobile-menu icon-mobile-burger js-mobile-menu-open">
                            <div class="icon-mobile-burger__inner"></div>
                        </div>
                        <div class="header__top-left">
                            <? $APPLICATION->IncludeComponent("bitrix:menu", "top", [
                                "ALLOW_MULTI_SELECT" => "N",
                                "CHILD_MENU_TYPE" => "left",
                                "DELAY" => "N",
                                "MAX_LEVEL" => "1",
                                "MENU_CACHE_TIME" => "3600",
                                "MENU_CACHE_TYPE" => "N",
                                "MENU_CACHE_USE_GROUPS" => "Y",
                                "ROOT_MENU_TYPE" => "top",
                                "USE_EXT" => "N",
                            ],
                                false
                            ); ?>
                        </div>
                        <div class="header__top-right">
                            <div class="header__search">
                                <div class="search js-search">
                                    <form class="search__inner" action="/search/" method="get">
                                        <input type="text" name="q" placeholder="Поиск" autocomplete="off">
                                        <button class="btn btn-search" type="submit"></button>
                                    </form>
                                    <div class="search__result">
                                        <div class="search__result-inner js-result-container"></div>
                                        <div class="search__result-bottom">
                                            <a class="search__result-all js-search-result-link" href="javascript:void(0);" data-url="/search/?q=">
                                                <span class="search__result-icon"></span>
                                                <p>Показать все результаты поиска</p>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <? if ($USER->IsAuthorized() && !CSite::InDir('/cart/')) {
                                $APPLICATION->IncludeComponent("bitrix:sale.basket.basket.line", "header", [
                                    "HIDE_ON_BASKET_PAGES" => "Y",
                                    // Не показывать на страницах корзины и оформления заказа
                                    "PATH_TO_BASKET" => SITE_DIR . "cart/",
                                    // Страница корзины
                                    "PATH_TO_ORDER" => SITE_DIR . "personal/order/make/",
                                    // Страница оформления заказа
                                    "PATH_TO_PERSONAL" => SITE_DIR . "personal/",
                                    // Страница персонального раздела
                                    "PATH_TO_PROFILE" => SITE_DIR . "personal/",
                                    // Страница профиля
                                    "PATH_TO_REGISTER" => SITE_DIR . "login/",
                                    // Страница регистрации
                                    "POSITION_FIXED" => "Y",
                                    // Отображать корзину поверх шаблона
                                    "POSITION_HORIZONTAL" => "right",
                                    // Положение по горизонтали
                                    "POSITION_VERTICAL" => "top",
                                    // Положение по вертикали
                                    "SHOW_AUTHOR" => "Y",
                                    // Добавить возможность авторизации
                                    "SHOW_DELAY" => "N",
                                    // Показывать отложенные товары
                                    "SHOW_EMPTY_VALUES" => "Y",
                                    // Выводить нулевые значения в пустой корзине
                                    "SHOW_IMAGE" => "Y",
                                    // Выводить картинку товара
                                    "SHOW_NOTAVAIL" => "N",
                                    // Показывать товары, недоступные для покупки
                                    "SHOW_NUM_PRODUCTS" => "Y",
                                    // Показывать количество товаров
                                    "SHOW_PERSONAL_LINK" => "N",
                                    // Отображать персональный раздел
                                    "SHOW_PRICE" => "Y",
                                    // Выводить цену товара
                                    "SHOW_PRODUCTS" => "Y",
                                    // Показывать список товаров
                                    "SHOW_SUMMARY" => "Y",
                                    // Выводить подытог по строке
                                    "SHOW_TOTAL_PRICE" => "Y",
                                    // Показывать общую сумму по товарам
                                ],
                                    false
                                );
                            } ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="header__middle">
                <div class="container">
                    <div class="header__middle-inner">
                        <div class="header__middle-logo"><a class="logo icon-logo" href="/"></a></div>
                        <div class="header__middle-links">
                            <div class="link-with-desc__list">
                                <div class="link-with-desc phone">
                                    <a class="link"
                                       href="tel:<?= Letsrock\Lib\Models\Property::getText('MAIN_PHONE') ?>"><?= Letsrock\Lib\Models\Property::getText('MAIN_PHONE') ?></a>
                                    <span class="desc">бесплатно</span>
                                </div>
                                <div class="link-with-desc mail">
                                    <a class="link"
                                       href="<?= Letsrock\Lib\Models\Property::getText('MAIN_EMAIL') ?>"><?= Letsrock\Lib\Models\Property::getText('MAIN_EMAIL') ?></a>
                                    <span class="desc">написать письмо</span>
                                </div>
                                <div class="link-with-desc download">
                                    <a class="link" href="<?= Letsrock\Lib\Models\Property::getFile('PRICE_LIST') ?>">Скачать
                                        прайс</a>
                                    <span class="desc">.pdf</span>
                                </div>
                            </div>
                        </div>
                        <div class="header__middle-cabinet">
                            <? if (!$USER->IsAuthorized()): ?>
                                <a class="personal-area-link js-modal-open" href="javascript:void()"
                                   data-modal-type="auth">
                                    <div class="personal-area-link__title"><span>Личный кабинет</span></div>
                                    <div class="personal-area-link__desc">вход</div>
                                </a>
                            <? else: ?>
                                <div class="personal-area-link">
                                    <a class="personal-area-link__title is-auth" href="/personal/">
                                        <span><?= $USER->GetFormattedName() ?></span>
                                    </a>
                                    <a class="personal-area-link__desc" href="/?logout=yes">выход</a>
                                </div>
                            <? endif; ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="header__bottom">
                <div class="container">
                    <div class="header__bottom-inner">
                        <? $APPLICATION->IncludeComponent("bitrix:menu", "catalog", [
                            "ALLOW_MULTI_SELECT" => "N",
                            "CHILD_MENU_TYPE" => "left",
                            "DELAY" => "N",
                            "MAX_LEVEL" => "1",
                            "MENU_CACHE_TIME" => "3600",
                            "MENU_CACHE_TYPE" => "N",
                            "MENU_CACHE_USE_GROUPS" => "Y",
                            "ROOT_MENU_TYPE" => "catalog",
                            "USE_EXT" => "N",
                        ],
                            false
                        ); ?>
                    </div>
                </div>
            </div>
        </header>