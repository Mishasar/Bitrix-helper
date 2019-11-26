<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

use Letsrock\Lib\Models\{CatalogHelper, Helper};

/**
 * @global CMain $APPLICATION
 * @var array $arParams
 * @var array $arResult
 * @var CatalogSectionComponent $component
 * @var CBitrixComponentTemplate $this
 * @var string $templateName
 * @var string $componentPath
 * @var string $templateFolder
 */

$this->setFrameMode(true);


$prices = [];

$prices = CatalogHelper::getElementPrice($arResult['ID']);
$saleSize = CatalogHelper::getSale($prices['NORMAL_PRICE']['PRICE'],
    $prices['SALE_PRICE']['PRICE']);

$arResult['PROPERTIES']['MORE_PHOTO']['VALUE'][] = $arResult['DETAIL_PICTURE']['ID'];

if (empty($arResult['PROPERTIES']['MORE_PHOTO']['VALUE'][0]) || empty($arResult['PROPERTIES']['MORE_PHOTO']['VALUE'][0])) {
    $imagesBig[]['src'] = IMG_DEFAULT;
    $imagesSmall[]['src'] = IMG_DEFAULT;
} else {
    $imagesBig = Helper::getArrayImages($arResult['PROPERTIES']['MORE_PHOTO']['VALUE'],
        ["width" => 1000, "height" => 1000]);
    $imagesSmall = Helper::getArrayImages($arResult['PROPERTIES']['MORE_PHOTO']['VALUE'],
        ["width" => 300, "height" => 300]);
}

$sortProps = CatalogHelper::sortProperties($arResult['DISPLAY_PROPERTIES']);

$presentation = CatalogHelper::getPresentation($arResult['IBLOCK_SECTION_ID']);

$name = $sortProps['HIDDEN']['FIELDS']['NAIMENOVANIE_NA_SAYTE']['VALUE'];

?>
    <section class="section catalog-detail__section" itemscope itemtype="http://schema.org/Product">
        <div class="container">
            <div class="catalog-detail">
                <div class="catalog-detail__left">
                    <!-- Дубль заголовка для мобильной версии (без h1)-->
                    <div class="catalog-detail__head catalog-detail__head_mobile">
                        <div class="catalog-detail__title"><?= $name ?></div>
                        <div class="catalog-detail__head-info">
                            <? if (!empty(CatalogHelper::getArticles($sortProps))): ?>
                                <div class="catalog-detail__article">
                                    <div class="catalog-detail__article-key">Артикул:</div>
                                    <div class="catalog-detail__article-value"><?= CatalogHelper::getArticles($sortProps) ?></div>
                                </div>
                            <? endif; ?>
                            <? if (CatalogHelper::productIsNew($sortProps)): ?>
                                <div class="catalog-detail__new">Новинка</div>
                            <? endif; ?>
                            <? if (!empty($presentation)): ?>
                                <a class="catalog-detail__download" href="<?= $presentation ?>">
                                    <div class="icon-download"></div>
                                    <span>Скачать презентацию</span>
                                </a>
                            <? endif; ?>
                        </div>
                    </div>
                    <div class="catalog-detail__image-list js-catalog-detail-image">
                        <? foreach ($imagesBig as $image): ?>
                            <a class="catalog-detail__image-item" href="<?= $image["src"] ?>"
                               data-fancybox="catalog-detail">
                                <div class="catalog-detail__image"
                                     style="background-image: url('<?= $image['src'] ?>')"></div>
                            </a>
                        <? endforeach; ?>
                    </div>
                    <div class="catalog-detail__image-mini-list js-catalog-detail-image-mini">
                        <? foreach ($imagesSmall as $image): ?>
                            <div class="catalog-detail__image-mini"
                                 style="background-image: url('<?= $image['src'] ?>')"></div>
                        <? endforeach; ?>
                    </div>
                </div>
                <div class="catalog-detail__right">
                    <div class="catalog-detail__head">
                        <h1 class="catalog-detail__title"><?= $arResult['NAME'] ?></h1>
                        <div class="catalog-detail__head-info">
                            <? if (!empty(CatalogHelper::getArticles($sortProps))): ?>
                                <div class="catalog-detail__article">
                                    <div class="catalog-detail__article-key">Артикул:</div>
                                    <div class="catalog-detail__article-value"><?= CatalogHelper::getArticles($sortProps) ?></div>
                                </div>
                            <? endif; ?>
                            <? if (CatalogHelper::productIsNew($sortProps)): ?>
                                <div class="catalog-detail__new">Новинка</div>
                            <? endif; ?>
                            <? if (!empty($presentation)): ?>
                                <a class="catalog-detail__download" href="<?= $presentation ?>">
                                    <div class="icon-download"></div>
                                    <span>Скачать презентацию</span>
                                </a>
                            <? endif; ?>
                        </div>
                    </div>
                    <div class="catalog-detail__body">
                        <div class="catalog-detail__options">
                            <? if (!empty($sortProps)): ?>
                                <? foreach ($sortProps['VIEW'] as $propType): ?>
                                    <? foreach ($propType as $propSection): ?>
                                        <? if (!empty($propSection['NAME'])): ?>
                                            <div class="catalog-detail__options-title"><?= $propSection['NAME'] ?></div>
                                        <? endif; ?>
                                        <div class="catalog-detail__options-box">
                                            <? foreach ($propSection['FIELDS'] as $property): ?>
                                                <div class="catalog-detail__options-row">
                                                    <div class="catalog-detail__options-key"><?= CatalogHelper::getClearName($property['NAME']) ?></div>
                                                    <? if ($property['CODE'] != PROPERTY_COLOR_LIGHT): ?>
                                                        <div class="catalog-detail__options-line"></div>
                                                    <? else: ?>
                                                        <div class="catalog-detail__options-scale">
                                                            <div class="catalog-detail__options-aim"
                                                                 style="left: <?= CatalogHelper::getLightPosition($property['DISPLAY_VALUE']) ?>%"></div>
                                                        </div>
                                                    <? endif; ?>
                                                    <div class="catalog-detail__options-value"><?= (is_array($property['DISPLAY_VALUE'])
                                                            ? implode(' / ', $property['DISPLAY_VALUE'])
                                                            : $property['DISPLAY_VALUE']) ?></div>
                                                </div>
                                                <? unset($property); ?>
                                            <? endforeach; ?>
                                        </div>
                                    <? endforeach; ?>
                                <? endforeach; ?>
                            <? endif; ?>
                        </div>
                        <div class="catalog-detail__commerce">
                            <? if ($USER->IsAuthorized()): ?>

                                <div class="catalog-detail__commerce-head">
                                    <? if (!empty($prices['SALE_PRICE'])): ?>
                                        <div class="catalog-detail__commerce-discount"
                                             id="<?= $itemIds['OLD_PRICE_ID'] ?>">
                                            <span><?= CurrencyFormat($prices['NORMAL_PRICE']['PRICE'], "RUB") ?></span>
                                            <div class="catalog-detail__commerce-mark">скидка <?= $saleSize ?>%</div>
                                        </div>
                                        <div class="catalog-detail__commerce-price" id="<?= $itemIds['PRICE_ID'] ?>">
                                            <b><?= CurrencyFormat($prices['SALE_PRICE']['PRICE'], "RUB") ?></b>
                                        </div>
                                    <? else: ?>
                                        <div class="catalog-detail__commerce-price" id="<?= $itemIds['PRICE_ID'] ?>">
                                            <b><?= CurrencyFormat($prices['NORMAL_PRICE']['PRICE'], "RUB") ?></b>
                                        </div>
                                    <? endif ?>
                                </div>
                                <div class="catalog-detail__commerce-body js-stores-wrap">
                                    <?
                                    $APPLICATION->IncludeComponent("letsrock:store",
                                        ".default",
                                        ['PRODUCT_ID' => $arResult['ID']]
                                    );
                                    ?>
                                </div>
                            <? else: ?>
                                <div class="catalog-detail__commerce-stock">
                                    <div class="catalog-detail__commerce-body">
                                        <div class="card__unauthorized">
                                            Для того чтобы узнать цену,
                                            <a href="javascript:void(0);" class="js-modal-open" data-modal-type="auth">авторизуйтесь</a>
                                        </div>
                                    </div>
                                </div>
                            <? endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="section">
        <div class="container">
            <div class="content-sidebar">
                <div class="content__box catalog-detail__feature">
                    <?
                    $APPLICATION->IncludeComponent("letsrock:advantage",
                        "catalog",
                        ['SECTION_ID' => $arResult['IBLOCK_SECTION_ID']]
                    );
                    ?>
                    <div class="catalog-detail__text">
                        <p><?= $arResult['DETAIL_TEXT'] ?></p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="section">
        <div class="container">
            <h2 class="h1">С этим так же покупают:</h2>
            <?
            global $sectionFilter;
            $sectionFilter = ['=PROPERTY_CML2_TRAITS' => CatalogHelper::getAssociatedProducts($sortProps)];

            $APPLICATION->IncludeComponent(
                "bitrix:catalog.section",
                "",
                [
                    "ACTION_VARIABLE" => "action",
                    "ADD_PICT_PROP" => "MORE_PHOTO",
                    "ADD_PROPERTIES_TO_BASKET" => "Y",
                    "ADD_SECTIONS_CHAIN" => "N",
                    "ADD_TO_BASKET_ACTION" => "ADD",
                    "AJAX_MODE" => "N",
                    "AJAX_OPTION_ADDITIONAL" => "",
                    "AJAX_OPTION_HISTORY" => "N",
                    "AJAX_OPTION_JUMP" => "N",
                    "AJAX_OPTION_STYLE" => "Y",
                    "BACKGROUND_IMAGE" => "UF_BACKGROUND_IMAGE",
                    "BASKET_URL" => "/personal/basket.php",
                    "BRAND_PROPERTY" => "BRAND_REF",
                    "BROWSER_TITLE" => "-",
                    "CACHE_FILTER" => "N",
                    "CACHE_GROUPS" => "Y",
                    "CACHE_TIME" => "36000000",
                    "CACHE_TYPE" => "A",
                    "COMPATIBLE_MODE" => "Y",
                    "CONVERT_CURRENCY" => "Y",
                    "CURRENCY_ID" => "RUB",
                    "CUSTOM_FILTER" => "",
                    "DATA_LAYER_NAME" => "dataLayer",
                    "DETAIL_URL" => "",
                    "DISABLE_INIT_JS_IN_COMPONENT" => "Y",
                    "DISCOUNT_PERCENT_POSITION" => "bottom-right",
                    "DISPLAY_BOTTOM_PAGER" => "N",
                    "DISPLAY_TOP_PAGER" => "N",
                    "ELEMENT_SORT_FIELD" => "sort",
                    "ELEMENT_SORT_FIELD2" => "id",
                    "ELEMENT_SORT_ORDER" => "asc",
                    "ELEMENT_SORT_ORDER2" => "desc",
                    "ENLARGE_PRODUCT" => "PROP",
                    "ENLARGE_PROP" => "NEWPRODUCT",
                    "FILTER_NAME" => "sectionFilter",
                    "HIDE_NOT_AVAILABLE" => "N",
                    "HIDE_NOT_AVAILABLE_OFFERS" => "N",
                    "IBLOCK_ID" => IB_CATALOG,
                    "IBLOCK_TYPE" => "catalog",
                    "INCLUDE_SUBSECTIONS" => "Y",
                    "LABEL_PROP" => ["NEWPRODUCT"],
                    "LABEL_PROP_MOBILE" => [],
                    "LABEL_PROP_POSITION" => "top-left",
                    "LAZY_LOAD" => "N",
                    "LINE_ELEMENT_COUNT" => "3",
                    "LOAD_ON_SCROLL" => "N",
                    "MESSAGE_404" => "",
                    "MESS_BTN_ADD_TO_BASKET" => "В корзину",
                    "MESS_BTN_BUY" => "Купить",
                    "MESS_BTN_DETAIL" => "Подробнее",
                    "MESS_BTN_LAZY_LOAD" => "Показать ещё",
                    "MESS_BTN_SUBSCRIBE" => "Подписаться",
                    "MESS_NOT_AVAILABLE" => "Нет в наличии",
                    "META_DESCRIPTION" => "-",
                    "META_KEYWORDS" => "-",
                    "OFFERS_CART_PROPERTIES" => [],
                    "OFFERS_FIELD_CODE" => ["", ""],
                    "OFFERS_LIMIT" => "5",
                    "OFFERS_PROPERTY_CODE" => [],
                    "OFFERS_SORT_FIELD" => "sort",
                    "OFFERS_SORT_FIELD2" => "id",
                    "OFFERS_SORT_ORDER" => "asc",
                    "OFFERS_SORT_ORDER2" => "desc",
                    "OFFER_ADD_PICT_PROP" => "MORE_PHOTO",
                    "OFFER_TREE_PROPS" => [],
                    "PAGER_BASE_LINK_ENABLE" => "N",
                    "PAGER_DESC_NUMBERING" => "N",
                    "PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
                    "PAGER_SHOW_ALL" => "N",
                    "PAGER_SHOW_ALWAYS" => "N",
                    "PAGER_TEMPLATE" => ".default",
                    "PAGER_TITLE" => "Товары",
                    "PAGE_ELEMENT_COUNT" => "8",
                    "PARTIAL_PRODUCT_PROPERTIES" => "N",
                    "PRICE_CODE" => ["BASE"],
                    "PRICE_VAT_INCLUDE" => "Y",
                    "PRODUCT_BLOCKS_ORDER" => "price,props,sku,quantityLimit,quantity,buttons,compare",
                    "PRODUCT_DISPLAY_MODE" => "Y",
                    "PRODUCT_ID_VARIABLE" => "id",
                    "PRODUCT_PROPERTIES" => ["NEWPRODUCT", "MATERIAL"],
                    "PRODUCT_PROPS_VARIABLE" => "prop",
                    "PRODUCT_QUANTITY_VARIABLE" => "",
                    "PRODUCT_ROW_VARIANTS" => "[{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':true}]",
                    "PRODUCT_SUBSCRIPTION" => "Y",
                    "PROPERTY_CODE" => [PROPERTY_NEW],
                    "PROPERTY_CODE_MOBILE" => [],
                    "RCM_PROD_ID" => [],
                    "RCM_TYPE" => "personal",
                    "SECTION_CODE" => "",
                    "SECTION_ID" => "",
                    "SECTION_ID_VARIABLE" => "SECTION_ID",
                    "SECTION_URL" => "",
                    "SECTION_USER_FIELDS" => [PROPERTY_NEW],
                    "SEF_MODE" => "Y",
                    "SET_BROWSER_TITLE" => "Y",
                    "SET_LAST_MODIFIED" => "N",
                    "SET_META_DESCRIPTION" => "Y",
                    "SET_META_KEYWORDS" => "Y",
                    "SET_STATUS_404" => "N",
                    "SET_TITLE" => "Y",
                    "SHOW_404" => "N",
                    "SHOW_ALL_WO_SECTION" => "Y",
                    "SHOW_CLOSE_POPUP" => "N",
                    "SHOW_DISCOUNT_PERCENT" => "Y",
                    "SHOW_FROM_SECTION" => "N",
                    "SHOW_MAX_QUANTITY" => "N",
                    "SHOW_OLD_PRICE" => "N",
                    "SHOW_PRICE_COUNT" => "1",
                    "SHOW_SLIDER" => "Y",
                    "SLIDER_INTERVAL" => "3000",
                    "SLIDER_PROGRESS" => "N",
                    "TEMPLATE_THEME" => "blue",
                    "USE_ENHANCED_ECOMMERCE" => "Y",
                    "USE_MAIN_ELEMENT_SECTION" => "N",
                    "USE_PRICE_COUNT" => "N",
                    "USE_PRODUCT_QUANTITY" => "N"
                ]
            ); ?>
        </div>
    </section>
<?
unset($actualItem, $itemIds, $jsParams);