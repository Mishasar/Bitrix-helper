<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}

$emptyBasket = empty($arResult['STOCKS']);
?>
<div class="js-basket" data-type="basket">
    <section class="section basket__section">
        <div class="container">
            <div class="content-half">
                <? if (!$emptyBasket): ?>
                    <? foreach ($arResult['STOCKS'] as $stock): ?>
                        <div class="content-half__box">
                            <section class="basket">
                                <div class="basket__body">
                                    <div class="basket__head">
                                        <p>Склад:</p>
                                        <span class="basket__city"><?= $stock['STOCK_CITY'] ?></span>
                                    </div>
                                    <div class="basket__list">
                                        <? foreach ($stock['PRODUCTS'] as $product): ?>
                                            <div class="basket__row js-basket-item"
                                                 data-product-id="<?= $product['BASKET_PRODUCT']['ID'] ?>">
                                                <div class="basket__col-img">
                                                    <a href="<?= $product['BASKET_PRODUCT']['DETAIL_PAGE_URL'] ?>">
                                                        <img src="<?= $product['PRODUCT_INFORMATION']['PREVIEW_PICTURE']['src'] ?>"
                                                             alt="<?= $product['PRODUCT_INFORMATION']['NAME'] ?>">
                                                    </a>
                                                </div>
                                                <div class="basket__col-name">
                                                    <a href="<?= $product['BASKET_PRODUCT']['DETAIL_PAGE_URL'] ?>"><?= $product['PRODUCT_INFORMATION']['NAME'] ?>
                                                        "</a>
                                                </div>
                                                <div class="basket__col-price">
                                                    <p>Цена</p>
                                                    <span><?= CurrencyFormat($product['BASKET_PRODUCT']['BASE_PRICE'],
                                                            "RUB") ?></span>
                                                </div>
                                                <div class="basket__col-quantity">
                                                    <div class="quantity">
                                                        <span class="quantity__minus js-quantity-minus"></span>
                                                        <input class="quantity__number js-quantity-input js-basket-item-quantity"
                                                               type="number"
                                                               max="<?= $product['STOCK']['AMOUNT'] ?>"
                                                               value="<?= (int)$product['BASKET_PRODUCT']['QUANTITY'] ?>">
                                                        <span class="quantity__plus js-quantity-plus"></span>
                                                    </div>
                                                </div>
                                                <div class="basket__col-sum">
                                                    <p>Сумма</p>
                                                    <span><?= CurrencyFormat($product['BASKET_PRODUCT']['QUANTITY'] * $product['BASKET_PRODUCT']['BASE_PRICE'],
                                                            "RUB") ?></span>
                                                </div>
                                                <a class="basket__col-remove icon-remove js-basket-item-remove"
                                                   href="javascript:void(0)"></a>
                                            </div>
                                        <? endforeach; ?>
                                    </div>
                                </div>
                                <div class="basket__result">
                                    <div class="basket__result-left">
                                        <div class="basket__result-data">
                                            <p>Вес</p><span><?= $stock['WEIGHT'] ?> кг.</span>
                                        </div>
                                        <div class="basket__result-data">
                                            <p>Объем</p><span><?= $stock['VOLUME'] ?> м²</span>
                                        </div>
                                    </div>
                                    <div class="basket__result-right">
                                        <div class="basket__result-sum">
                                            <p>Сумма</p><span><?= CurrencyFormat($stock['COST'], "RUB") ?></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="basket__text-attention">
                                    * Итоговый объем и вес заказа
                                    может отличаться от заявленного
                                </div>
                            </section>
                        </div>
                    <? endforeach; ?>
                <? else: ?>
                    <h3 class="h4">Ваша корзина пуста</h3>
                <? endif; ?>
            </div>
        </div>
    </section>
    <? if (!$emptyBasket): ?>
        <section class="section basket-total__section">
            <div class="container">
                <div class="basket-total__wrap">
                    <div class="basket-total__wrap-center">
                        <div class="basket-total">
                            <div class="basket-total__body">
                                <div class="basket-total__data">
                                    <p>Вес</p><span><?= $arResult['COMMON']['WEIGHT'] ?> кг.</span>
                                </div>
                                <div class="basket-total__data">
                                    <p>Объем</p><span><?= $arResult['COMMON']['VOLUME'] ?> м²</span>
                                </div>
                                <div class="basket-total__message">
                                    <p>* Итоговый объем и вес заказа может отличаться от заявленного</p>
                                </div>
                                <div class="basket-total__result">
                                    <p>Сумма</p><span><?= $arResult['COMMON']['COST'] ?></span>
                                </div>
                            </div>
                            <div class="basket-total__bottom">
                                <? if ($arResult['COMMON']['BONUS_BY_COST'] > 0): ?>
                                    <div class="basket-total__bonus">
                                        <a href="/catalog/">Добавить товары</a>
                                        на сумму
                                        <b><?= CurrencyFormat($arResult['COMMON']['BONUS_BY_COST'], "RUB") ?></b>
                                        для получения бонусов
                                    </div>
                                <? endif; ?>
                                <a class="basket-total__order btn btn-yellow" href="/cart/order.php">
                                    Перейти к офоромлению заказа
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    <? endif; ?>
</div>