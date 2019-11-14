<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}

$emptyBasket = empty($arResult['STOCKS']);
?>
<div class="js-basket" data-type="order">
    <section class="section basket__section js-basket-main">
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
        <section class="section basket-total__section js-order-section">
            <div class="container">
                <form class="validator js-form-order" method="post" action="/ajax/basket/order/">
                    <div class="basket-total__wrap">
                        <div class="basket-total__wrap-left">
                            <div class="basket-total__form">
                                <h3 class="h3 basket-total__form-title">Личные данные</h3>
                                <div class="basket-total__form-field">
                                    <label class="field">
                                        <p>Транспортная компания</p>
                                        <input type="text" name="company" value="" data-validator-require="true">
                                    </label>
                                </div>
                                <div class="basket-total__form-field">
                                    <label class="field">
                                        <p>Город</p>
                                        <input type="text" name="city" data-validator-require="true">
                                    </label>
                                </div>
                                <div class="basket-total__form-field">
                                    <label class="field">
                                        <p>Название организации / Ф.И.О.</p>
                                        <input type="text" name="name" data-validator-require="true">
                                    </label>
                                </div>
                                <div class="basket-total__form-field">
                                    <label class="field">
                                        <p>ИНН / Паспортные данные</p>
                                        <input type="text" name="inn-passport" data-validator-require="true">
                                    </label>
                                </div>
                                <div class="basket-total__form-field">
                                    <label class="field">
                                        <p>Адрес</p>
                                        <input type="text" name="address" data-validator-require="true">
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="basket-total__wrap-right">
                            <div class="basket-total">
                                <div class="basket-total__comment">
                                    <label class="field">
                                        <p>Комментарий</p>
                                        <textarea name="comment"></textarea>
                                    </label>
                                </div>
                                <div class="basket-total__body js-basket-additional">
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
                                        <p>Сумма</p><span><?= CurrencyFormat($arResult['COMMON']['COST'],
                                                "RUB") ?></span>
                                    </div>
                                </div>
                                <div class="basket-total__bottom">
                                    <div class="basket-total__bonus">
                                        <a href="#">Добавить товары</a>
                                        на сумму
                                        <b>100&nbsp;500&nbsp;₽</b>
                                        для получения бонусов
                                    </div>
                                    <button class="basket-total__order btn btn-yellow" type="submit">Оформить заказ
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </section>
    <? endif; ?>
</div>