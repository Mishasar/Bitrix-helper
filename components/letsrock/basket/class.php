<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}

\Bitrix\Main\Loader::includeModule('letsrock.lib');
\Bitrix\Main\Loader::includeModule('letsrock.bonus');

class BasketComponent extends CBitrixComponent
{
    public function onPrepareComponentParams($arParams)
    {
        $result = [
            "CACHE_TYPE" => $arParams["CACHE_TYPE"],
            "CACHE_TIME" => isset($arParams["CACHE_TIME"]) ? $arParams["CACHE_TIME"] : 36000000,
        ];

        return $result;
    }

    /**
     * @return array|mixed
     * @throws \Bitrix\Main\LoaderException
     */
    public function executeComponent()
    {
        if ($this->startResultCache()) {
            global $USER;
            $informationBonus = new \Letsrock\Bonus\Information($USER->GetID());

            $this->arResult = \Letsrock\Lib\Models\Basket::getBasketByStocks();
            $this->arResult['COMMON']['BONUS_BY_COST'] = $informationBonus->getPriceDiff($this->arResult['COMMON']['COST']);
            $this->includeComponentTemplate();
        }

        return $this->arResult;
    }
} ?>