<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}
global $USER;
?>
<? if ($arResult[STORE_BARNAUL_ID]["AMOUNT"] > 0): ?>
    <div class="catalog-detail__commerce-stock js-buy-block"
         data-product-id="<?= $arParams['PRODUCT_ID'] ?>"
         data-store-id="<?= $arResult[STORE_BARNAUL_ID]["STORE_ID"] ?>">
        <div class="catalog-detail__commerce-name">Склад в Барнауле</div>
        <div class="catalog-detail__commerce-availability">
            <span><?= $arResult[STORE_BARNAUL_ID]["AMOUNT"] ?></span>
            шт. в наличии
        </div>
        <div class="catalog-detail__commerce-quantyty">
            <div class="quantity"><span class="quantity__minus js-quantity-minus"></span>
                <input class="quantity__number js-quantity-input"
                       type="number"
                       max="<?= $arResult[STORE_BARNAUL_ID]["AMOUNT"] ?>"
                       value="1">
                <span class="quantity__plus js-quantity-plus"></span>
            </div>
        </div>
        <div class="catalog-detail__commerce-button">
            <a class="btn btn-yellow js-add-to-basket" href="javascript:void(0);">
                В корзину
            </a>
        </div>
    </div>
<? endif; ?>
<? if ($arResult[STORE_MOSCOW_ID]["AMOUNT"] > 0): ?>
    <div class="catalog-detail__commerce-stock js-buy-block"
         data-product-id="<?= $arParams['PRODUCT_ID'] ?>"
         data-store-id="<?= $arResult[STORE_MOSCOW_ID]["STORE_ID"] ?>">
        <div class="catalog-detail__commerce-name">Склад в Москве</div>
        <div class="catalog-detail__commerce-availability">
            <span><?= $arResult[STORE_MOSCOW_ID]["AMOUNT"] ?></span>
            шт. в наличии
        </div>
        <div class="catalog-detail__commerce-quantyty">
            <div class="quantity">
                <span class="quantity__minus js-quantity-minus"></span>
                <input class="quantity__number js-quantity-input"
                       type="number"
                       max="<?= $arResult[STORE_MOSCOW_ID]["AMOUNT"] ?>"
                       value="1">
                <span class="quantity__plus js-quantity-plus"></span>
            </div>
        </div>
        <div class="catalog-detail__commerce-button">
            <a class="btn btn-yellow js-add-to-basket" href="javascript:void(0);">
                В корзину
            </a>
        </div>
    </div>
<? endif; ?>
