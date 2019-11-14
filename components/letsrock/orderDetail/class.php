<? use Bitrix\Main\Loader;

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}
Loader::includeModule('sale');
Loader::includeModule("catalog");
Loader::includeModule('letsrock.lib');

class OrderDetailComponent extends CBitrixComponent
{
    public function onPrepareComponentParams($arParams)
    {
        $result = [
            "ORDER_ID" => $arParams["ORDER_ID"],
            "CACHE_TYPE" => $arParams["CACHE_TYPE"],
            "CACHE_TIME" => 0,
        ];

        return $result;
    }

    /**
     * @return array|mixed
     */
    public function executeComponent()
    {
        if ($this->startResultCache()) {
            $orderInfo = \Letsrock\Lib\Controllers\OrderController::getOrder($this->arParams["ORDER_ID"]);
            $this->arResult['STOCKS'] = $orderInfo['ITEMS'];
            $this->arResult['STATUS'] = $orderInfo['STATUS'];
            $this->arResult['ORDER_ID'] = $this->arParams["ORDER_ID"];
            $arResult['BONUSES'] = 0; //Бонусы не работают
            $this->includeComponentTemplate();
        }

        return $this->arResult;
    }
} ?>