<?php

namespace Letsrock\Lib\Controllers;

/*
 * Class CatalogController
 * Контроллер каталога
 */

use Letsrock\Lib\Models\CatalogHelper;

class CatalogController extends Controller
{
    public function getRenderModal($request)
    {
        $stockCode = [];
        $prices = CatalogHelper::getElementPrice($request['PRODUCT_ID']);

        ob_start();
        global $APPLICATION;
        ?>
        <div class="catalog-detail__commerce-head">
            <? if (!empty($prices['SALE_PRICE'])): ?>
                <div class="catalog-detail__commerce-discount">
                    <span><?= CurrencyFormat($prices['NORMAL_PRICE']['PRICE'], "RUB") ?></span>
                </div>
                <div class="catalog-detail__commerce-price">
                    <b><?= CurrencyFormat($prices['SALE_PRICE']['PRICE'], "RUB") ?></b>
                </div>
            <? else: ?>
                <div class="catalog-detail__commerce-price">
                    <b><?= CurrencyFormat($prices['NORMAL_PRICE']['PRICE'], "RUB") ?></b>
                </div>
            <? endif; ?>
        </div>
        <div class="catalog-detail__commerce-body">
            <? $APPLICATION->IncludeComponent("letsrock:store",
                ".default",
                ['PRODUCT_ID' => $request['PRODUCT_ID']]
            ); ?>
        </div>
        <?
        $stockCode['INNER_HTML'] = ob_get_contents();
        ob_end_clean();

        echo Controller::sendAnswer($stockCode);
    }
}