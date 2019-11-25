<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

use \Letsrock\Lib\Models\{CatalogHelper, Helper};

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

$imagesBig = Helper::getArrayImages($arResult['PROPERTIES']['MORE_PHOTO']['VALUE'],
    ["width" => 1000, "height" => 1000]);
$imagesSmall = Helper::getArrayImages($arResult['PROPERTIES']['MORE_PHOTO']['VALUE'],
    ["width" => 300, "height" => 300]);

$sortProps = CatalogHelper::sortProperties($arResult['DISPLAY_PROPERTIES']);

$presentation = CatalogHelper::getPresentation($arResult['IBLOCK_SECTION_ID']);

?>
    <section class="section catalog-detail__section" itemscope itemtype="http://schema.org/Product">
        <div class="container">
            <div class="catalog-detail">
                <div class="catalog-detail__left">
                    <!-- Дубль заголовка для мобильной версии (без h1)-->
                    <div class="catalog-detail__head catalog-detail__head_mobile">
                        <div class="catalog-detail__title"><?= $name ?></div>
                        <div class="catalog-detail__head-info">
                            <? if (!empty($arResult['DISPLAY_PROPERTIES']['CML2_ARTICLE'])): ?>
                                <div class="catalog-detail__article">
                                    <div class="catalog-detail__article-key">Артикул:</div>
                                    <div class="catalog-detail__article-value"><?= $arResult['DISPLAY_PROPERTIES']['CML2_ARTICLE']['VALUE'] ?></div>
                                </div>
                            <? endif; ?>
                            <div class="catalog-detail__new">Новинка</div>
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
                                <div class="catalog-detail__article">
                                    <div class="catalog-detail__article-key">Артикул:</div>
                                    <div class="catalog-detail__article-value"><?= CatalogHelper::getArticles($arResult['ID']) ?></div>
                                </div>
                            <div class="catalog-detail__new">Новинка</div>
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
                                <? foreach ($sortProps as $propType): ?>
                                    <? foreach ($propType as $propSection): ?>
                                        <? if (!empty($propSection['NAME'])): ?>
                                            <div class="catalog-detail__options-title"><?= $propSection['NAME'] ?></div>
                                        <? endif; ?>
                                        <div class="catalog-detail__options-box">
                                            <? foreach ($propSection['FIELDS'] as $property): ?>
                                                <div class="catalog-detail__options-row">
                                                    <div class="catalog-detail__options-key"><?= CatalogHelper::getClearName($property['NAME']) ?></div>
                                                    <div class="catalog-detail__options-line"></div>
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


<?
unset($actualItem, $itemIds, $jsParams);