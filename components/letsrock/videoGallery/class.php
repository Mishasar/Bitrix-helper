<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}

use Letsrock\Lib\Models\SectionGallery;

\Bitrix\Main\Loader::includeModule('letsrock.lib');

class VideoGalleryComponent extends CBitrixComponent
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
            $model = new \Letsrock\Lib\Models\VideoGallery();
            $this->arResult['ITEMS'] = $model->getAll();
            $this->arResult['CHANNEL_URL'] = \Letsrock\Lib\Models\Property::getText('CHANNEL_YOUTUBE_URL');

            $this->includeComponentTemplate();
        }

        return $this->arResult;
    }
} ?>