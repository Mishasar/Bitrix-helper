<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}

\Bitrix\Main\Loader::includeModule('letsrock.lib');

/**
 * Class ManagerCurrentUser
 */
class ManagerCurrentUser extends CBitrixComponent
{
    public function onPrepareComponentParams($arParams)
    {
        $result = [
            "NAME" => $arParams["NAME"],
            "EMAIL" => $arParams["EMAIL"],
            "IMAGE_ID" => $arParams["IMAGE_ID"],
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
        global $USER;

        if ($this->startResultCache($this->arParams["CACHE_TIME"], [$USER->GetID()])) {
            $this->arResult = \Letsrock\Lib\Models\User::getManager();
            $this->includeComponentTemplate();
        }

        return $this->arResult;
    }
} ?>