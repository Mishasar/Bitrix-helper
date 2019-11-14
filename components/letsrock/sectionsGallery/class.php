<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}

use Letsrock\Lib\Models\SectionGallery;

\Bitrix\Main\Loader::includeModule('letsrock.lib');

class SectionsGalleryComponent extends CBitrixComponent
{
    public function onPrepareComponentParams($arParams)
    {
        $result = [
            "CACHE_TYPE" => $arParams["CACHE_TYPE"],
            "CACHE_TIME" => isset($arParams["CACHE_TIME"]) ? $arParams["CACHE_TIME"] : 36000000,
            "HIDE_HEADING" => isset($arParams["HIDE_HEADING"]) ? false : true,
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
            $jobModel = new SectionGallery();
            $this->arResult['ITEMS'] = $jobModel->getAll();
            $this->arResult['BANNER'] = \Letsrock\Lib\Models\Property::get('BANNER_ON_MAIN');
            $this->arResult['BANNER']['LINK'] = \Letsrock\Lib\Models\Property::getText('BANNER_ON_MAIN_LINK');
            $this->includeComponentTemplate();
        }

        return $this->arResult;
    }
} ?>