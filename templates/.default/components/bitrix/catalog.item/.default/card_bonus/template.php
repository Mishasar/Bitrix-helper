<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

/**
 * @global CMain $APPLICATION
 * @var array $arParams
 * @var array $item
 * @var array $actualItem
 * @var array $minOffer
 * @var array $itemIds
 * @var array $price
 * @var array $measureRatio
 * @var bool $haveOffers
 * @var bool $showSubscribe
 * @var array $morePhoto
 * @var bool $showSlider
 * @var bool $itemHasDetailUrl
 * @var string $imgTitle
 * @var string $productTitle
 * @var string $buttonSizeClass
 * @var CatalogSectionComponent $component
 */
$smallImage = [];

if (!empty($item['DETAIL_PICTURE'])) {
    $smallImage = CFile::ResizeImageGet($item['DETAIL_PICTURE'],
        ['width' => 240, 'height' => 240],
        BX_RESIZE_IMAGE_PROPORTIONAL,
        true);
} else {
    $smallImage['src'] = IMG_DEFAULT;
}
$prices = \Letsrock\Lib\Models\CatalogHelper::getElementPrice($actualItem['ID']);
$newLabel = !empty($item['PROPERTIES'][PROPERTY_NEW]['VALUE_XML_ID']) ? true : false;
$productTitle = !empty($item['PROPERTIES'][PROPERTY_NAME]['VALUE']) ? $item['PROPERTIES'][PROPERTY_NAME]['VALUE'] : $productTitle;
$bonusInformation = new Letsrock\Bonus\Information($USER->GetID());
$userBonusCount = $bonusInformation->getCountBonuses();
?>
<? if ($newLabel): ?>
    <div class="card__new">Новинка</div>
<? endif; ?>
<span class="card__title" href="<?= $item['DETAIL_PAGE_URL'] ?>"><?= $productTitle ?></span>
<span class="card__img" href="<?= $item['DETAIL_PAGE_URL'] ?>">
    <img src="<?= $smallImage['src'] ?>" alt="<?= $productTitle ?>" title="<?= $productTitle ?>">
</span>
<div class="card__bottom js-bonusBuyComponent">
    <div class="card__price">
        <span><?= CurrencyFormat($item['PROPERTIES']['BONUS_COST']['VALUE'], "BON") ?></span>
    </div>
    <? if ($userBonusCount > $item['PROPERTIES']['BONUS_COST']['VALUE']): ?>
        <a class="btn-yellow js-getBonusProduct"
           href="javascript:void(0);"
           data-product-id="<?= $item['ID'] ?>">Получить</a>
    <? endif; ?>
</div>

