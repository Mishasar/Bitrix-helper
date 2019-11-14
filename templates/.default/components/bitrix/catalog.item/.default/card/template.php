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

$smallImage = CFile::ResizeImageGet($item['DETAIL_PICTURE'],
    ['width' => 240, 'height' => 240],
    BX_RESIZE_IMAGE_PROPORTIONAL,
    true);

$prices = \Letsrock\Lib\Models\CatalogHelper::getElementPrice($actualItem['ID']);
?>

<div class="card__new" style="border: 1px solid red;">Новинка</div>
<a class="card__title" href="<?= $item['DETAIL_PAGE_URL'] ?>"><?= $productTitle ?></a>
<a class="card__img" href="<?= $item['DETAIL_PAGE_URL'] ?>">
    <img src="<?= $smallImage['src'] ?>" alt="<?= $productTitle ?>" title="<?= $imgTitle ?>">
</a>
<? if ($USER->IsAuthorized()): ?>
    <div class="card__bottom">
        <div class="card__price">
            <? if (!empty($prices['SALE_PRICE'])): ?>
                <div class="card__price-old"><?= CurrencyFormat($prices['NORMAL_PRICE']['PRICE'], "RUB") ?></div>
                <span><?= CurrencyFormat($prices['SALE_PRICE']['PRICE'], "RUB") ?></span>
            <? else: ?>
                <span><?= CurrencyFormat($prices['NORMAL_PRICE']['PRICE'], "RUB") ?></span>
            <? endif; ?>
        </div>
        <a class="btn-yellow js-modal-add2basket-open" href="javascript:void(0);"
           data-product-id="<?= $item['ID'] ?>">В корзину</a>
    </div>
<? else: ?>
    <div class="card__bottom">
        <div class="card__unauthorized">
            Для того чтобы узнать цену,
            <a href="javascript:void(0);" class="js-modal-open" data-modal-type="auth">авторизуйтесь</a>
        </div>
    </div>
<? endif; ?>
