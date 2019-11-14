<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}
?>
<div class="cabinet-box">
    <div class="cabinet-head">
        <h3 class="h3 cabinet-head__title">История заказов</h3>
        <a class="cabinet-logout" href="/?logout=yes">Выйти</a>
    </div>
    <div class="cabinet-body">
        <div class="cabinet-history">
            <? foreach ($arResult['ORDERS'] as $order): ?>
                <div class="cabinet-history__row js-order-history-item">
                    <div class="cabinet-history__col">
                        <div class="cabinet-history__col-title">Номер заказа</div>
                        <div class="cabinet-history__col-value">№<?=$order['ID']?></div>
                    </div>
                    <div class="cabinet-history__col">
                        <div class="cabinet-history__col-title">Дата оформления</div>
                        <div class="cabinet-history__col-value"><?=$order['DATE_INSERT']->format("d.m.Y");?></div>
                    </div>
                    <div class="cabinet-history__col">
                        <div class="cabinet-history__col-title">Статус заказа</div>
                        <div class="cabinet-history__col-value"><?=$order['STATUS']['NAME']?></div>
                    </div>
                    <div class="cabinet-history__col">
                        <div class="cabinet-history__col-title">Повтор</div>
                        <a class="cabinet-history__col-repeat js-order-repeat" href="javascript:void(0);" data-id="<?=$order['ID']?>">Повторить заказ</a>
                    </div>
                    <div class="cabinet-history__col">
                        <a class="btn btn-yellow" href="/personal/order_history/order_detail.php?ID=<?=$order['ID']?>">Состав заказа</a>
                    </div>
                </div>
            <? endforeach; ?>
        </div>
    </div>
</div>