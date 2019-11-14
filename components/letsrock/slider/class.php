<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}

use \Letsrock\Lib\Models\MainSlider;

\Bitrix\Main\Loader::includeModule('letsrock.lib');

class SliderComponent extends CBitrixComponent
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
            $jobModel = new MainSlider();
            $this->arResult = $jobModel->getAll();
            $this->includeComponentTemplate();
        }

        return $this->arResult;
    }
} ?>