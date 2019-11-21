<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}

use \Letsrock\Lib\Models\Job;

\Bitrix\Main\Loader::includeModule('letsrock.lib');

/**
 * Class ManagerComponent
 */
class ManagerListComponent extends CBitrixComponent
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
     * @throws \Bitrix\Main\ArgumentException
     * @throws \Bitrix\Main\LoaderException
     * @throws \Bitrix\Main\ObjectPropertyException
     * @throws \Bitrix\Main\SystemException
     */
    public function executeComponent()
    {
        if ($this->startResultCache()) {
            $this->arResult = \Letsrock\Lib\Models\Managers::getAll();
            $this->includeComponentTemplate();
        }

        return $this->arResult;
    }
} ?>