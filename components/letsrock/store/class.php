<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}


\Bitrix\Main\Loader::includeModule('letsrock.lib');

class StoreComponent extends CBitrixComponent
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
            $this->arResult = \Letsrock\Lib\Models\CatalogHelper::getStoreAmount($this->arParams['PRODUCT_ID'], [
                STORE_BARNAUL_ID,
                STORE_MOSCOW_ID
            ]);
            $this->includeComponentTemplate();
        }

        return $this->arResult;
    }
} ?>