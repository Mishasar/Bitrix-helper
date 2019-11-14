<?if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true) die();
/**
 * @global array $arParams
 * @global CUser $USER
 * @global CMain $APPLICATION
 * @global string $cartId
 */
?>
<div class="header__basket-wrap">
    <div class="header__basket-commercial">
        <div class="header__basket-quantity">
            <span class="header__basket-count"><?=$arResult['NUM_PRODUCTS']?></span>
            <span class="header__basket-units">шт.</span>
        </div>
        <div class="header__basket-total"><?=$arResult['TOTAL_PRICE']?></div>
    </div>
    <a class="header__basket" href="<?= $arParams['PATH_TO_BASKET'] ?>">
        <div class="icon-cart"></div>
        <span>Корзина</span></a>
</div>
