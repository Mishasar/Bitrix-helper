<? use Bitrix\Main\Loader;

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}
Loader::includeModule('sale');
Loader::includeModule("catalog");
Loader::includeModule('letsrock.lib');

class OrderListComponent extends CBitrixComponent
{
    public function onPrepareComponentParams($arParams)
    {
        $result = [
            "PRODUCT_ID" => $arParams["PRODUCT_ID"],
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
            $this->arResult['ORDERS'] = \Letsrock\Lib\Controllers\OrderController::getOrders();
            $this->includeComponentTemplate();
        }

        return $this->arResult;
    }
} ?>