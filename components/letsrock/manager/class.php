<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}

use \Letsrock\Lib\Models\Job;

\Bitrix\Main\Loader::includeModule('letsrock.lib');

/**
 * Class ManagerComponent
 */
class ManagerComponent extends CBitrixComponent
{
    public function onPrepareComponentParams($arParams)
    {
        $result = [
            "NAME" => $arParams["NAME"],
            "EMAIL" => $arParams["EMAIL"],
            "IMAGE_SRC" => $arParams["IMAGE_SRC"],
            "POSITION" => $arParams["POSITION"],
            "PHONE" => $arParams["PHONE"],
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
            $this->includeComponentTemplate();
        }

        return $this->arResult;
    }
} ?>