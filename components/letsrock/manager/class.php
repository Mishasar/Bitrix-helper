<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}

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
        if ($this->startResultCache()) {
            $imageArray = CFile::ResizeImageGet(
                $this->arParams["IMAGE_ID"],
                ["width" => 80, "height" => 80],
                BX_RESIZE_IMAGE_PROPORTIONAL
            );

            if ($imageArray) {
                $this->arResult['IMAGE_SRC'] = $imageArray['src'];
            }

            $this->includeComponentTemplate();
        }

        return $this->arResult;
    }
} ?>