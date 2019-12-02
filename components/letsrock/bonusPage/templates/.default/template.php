<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}
?>
<div class="cabinet-head">
    <div class="cabinet-head__bonus">
        Бонусов:<b><?= $arResult['BONUS_COUNT'] ?></b></div>
    <a class="cabinet-logout" href="/?logout=yes">Выйти</a>
</div>
<div class="cabinet-body">
    <div class="cabinet-bonus">
        <div class="cabinet-bonus__content">
            <h4 class="h4 cabinet-bonus__title">Как начисляются бонусы?</h4>
            <div class="cabinet-bonus__text">
                <p>При покупке товара (после смены статуса «оплачено или «отгружено») на бонусный счет контрагента
                    начисляются бонусы по следующим схемам:</p>
            </div>
            <?
            $countMonth = count($arResult['BONUS_STRUCTURE']);
            $iterator = 1;
            foreach ($arResult['BONUS_STRUCTURE'] as $key => $month): ?>
            <div class="cabinet-bonus__opstion-block">

                <? if ($iterator != $countMonth): ?>
                    <div class="cabinet-bonus__opstion-title">На <?= $key ?> месяц сотрудничества</div>
                <? else: ?>
                    <div class="cabinet-bonus__opstion-title">На последующие месяцы сотрудничества</div>
                <? endif; ?>
                <div class="cabinet-bonus__opstion-list">
                    <? foreach ($month['ELEMENTS'] as $cost => $bonusCount): ?>
                        <div class="cabinet-bonus__opstion">
                            <div class="cabinet-bonus__opstion-value"><?= $cost ?> рублей</div>
                            <div class="cabinet-bonus__opstion-line"></div>
                            <div class="cabinet-bonus__opstion-bonus"><?= $bonusCount['PROPERTY_COUNT_BONUSES_VALUE'] ?>
                                бонусов
                            </div>
                        </div>
                    <? endforeach; ?>
                </div>
            </div>
        </div>
        <? $iterator++; ?>
        <? endforeach; ?>
    </div>
</div>