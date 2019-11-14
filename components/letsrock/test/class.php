<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}

use \Letsrock\Lib\Models\Job;

\Bitrix\Main\Loader::includeModule('letsrock.lib');

class JobComponent extends CBitrixComponent
{
    public function onPrepareComponentParams($arParams)
    {
        $result = [
            "MAIN" => $arParams["MAIN"],
            "BOTTOM_SECTION" => $arParams["BOTTOM_SECTION"],
            "TOP_SECTION" => $arParams["TOP_SECTION"],
            "CACHE_TYPE" => $arParams["CACHE_TYPE"],
            "CACHE_TIME" => isset($arParams["CACHE_TIME"]) ? $arParams["CACHE_TIME"] : 36000000,
        ];

        return $result;
    }

    /**
     * @return array|mixed
     */
    public function executeComponent()
    {
        if ($this->startResultCache()) {
            $jobModel = new Job();
            $this->arResult = $jobModel->getAll($this->arParams['TOP_SECTION'], $this->arParams['BOTTOM_SECTION']);
            $this->includeComponentTemplate();
        }

        return $this->arResult;
    }
} ?>