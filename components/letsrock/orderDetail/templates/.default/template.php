<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}
?>
<div class="cabinet-box">
    <div class="cabinet-head">
        <a class="cabinet-head__back" href="/personal/order_history/">Назад к списку</a>
        <a class="cabinet-logout" href="/?logout=yes">Выйти</a>
    </div>
    <div class="cabinet-body">
        <div class="cabinet-history-detail">
            <div class="cabinet-history-detail__head js-order-history-item">
                <div class="cabinet-history-detail__data">
                    <p>Номер заказа</p><span>№<?= $arResult['ORDER_ID'] ?></span>
                </div>
                <div class="cabinet-history-detail__data">
                    <p>Бонусные баллы за этот заказ</p><span><?= $arResult['BONUSES'] ?></span>
                </div>
                <div class="cabinet-history-detail__data">
                    <p>Статус заказа</p><span><?= $arResult['STATUS']['NAME'] ?></span>
                </div>
                <div class="cabinet-history-detail__button">
                    <a class="btn btn-yellow js-order-repeat" href="javascript:void(0);"
                       data-id="<?= $arResult['ORDER_ID'] ?>" data-reload="false">Повторить</a>
                </div>
            </div>
            <div class="cabinet-history-detail__body">
                <h4 class="h4 cabinet-history-detail__title">Товары</h4>
                <div class="cabinet-history-detail__list">
                    <? foreach ($arResult['STOCKS'] as $stock): ?>
                        <? foreach ($stock['PRODUCTS'] as $product): ?>
                            <div class="cabinet-history-detail__row">
                                <a class="cabinet-history-detail__col-img"
                                   href="<?= $product['PRODUCT_INFORMATION']['DETAIL_PAGE_URL'] ?>">
                                    <img src="<?= $product['PRODUCT_INFORMATION']['PREVIEW_PICTURE']['src'] ?>"
                                         alt="<?= $product['PRODUCT_INFORMATION']['NAME'] ?>"></a>
                                <a class="cabinet-history-detail__col-title"
                                   href="<?= $product['PRODUCT_INFORMATION']['DETAIL_PAGE_URL'] ?>"><?= $product['PRODUCT_INFORMATION']['NAME'] ?></a>
                                <div class="cabinet-history-detail__col-data">
                                    <p>Артикул</p><span><?= $product['PRODUCT_INFORMATION']['ARTICLE'] ?></span>
                                </div>
                                <div class="cabinet-history-detail__col-data">
                                    <p>Цена за штуку</p>
                                    <span><?= CurrencyFormat($product['BASKET_PRODUCT']['BASE_PRICE'],
                                            "RUB") ?></span>
                                </div>
                                <div class="cabinet-history-detail__col-data">
                                    <p>Склад</p><span><?= $stock['STOCK_CITY'] ?></span>
                                </div>
                                <div class="cabinet-history-detail__col-data">
                                    <p>Количество</p><span><?= (int)$product['BASKET_PRODUCT']['QUANTITY'] ?></span>
                                </div>
                                <div class="cabinet-history-detail__col-sum">
                                    <p>Сумма</p>
                                    <span><?= CurrencyFormat($product['BASKET_PRODUCT']['QUANTITY'] * $product['BASKET_PRODUCT']['BASE_PRICE'],
                                            "RUB") ?></span>
                                </div>
                            </div>
                        <? endforeach; ?>
                    <? endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</div>