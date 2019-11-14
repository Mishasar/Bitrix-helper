<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}

\Bitrix\Main\Loader::includeModule('letsrock.lib');

class AdvantagesComponent extends CBitrixComponent
{
    public function onPrepareComponentParams($arParams)
    {
        $result = [
            "SECTION_ID" => !empty($arParams["SECTION_ID"]) ? $arParams["SECTION_ID"] : false,
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
            $model = new \Letsrock\Lib\Models\Advantages();
            $this->arResult = $model->getAll($this->arParams['SECTION_ID']);
            $this->includeComponentTemplate();
        }

        return $this->arResult;
    }
} ?>