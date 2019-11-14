<?php

namespace Letsrock\Lib\Models;

use Bitrix\Main\Loader;
use CFile;
use CIBlockElement;

/*
 * Class MainSlider
 */

class MainSlider
{
    /**
     * Возвращает все слайды
     *
     * @return array
     * @throws \Bitrix\Main\LoaderException
     */
    function getAll()
    {
        if (Loader::includeModule('iblock')) {
            $arSelect = [
                "ID",
                "NAME",
                "PREVIEW_PICTURE",
                "PREVIEW_TEXT",
                "PROPERTY_LINK",
                "PROPERTY_LINK_TEXT",
            ];

            $arFilter = [
                "IBLOCK_ID" => IntVal(IB_SLIDER),
                "ACTIVE" => "Y"
            ];

            $res = CIBlockElement::GetList(["SORT" => "ASC"], $arFilter, false, ["nPageSize" => 10], $arSelect);
            $arFields = [];

            while ($ob = $res->GetNextElement()) {
                $arFields[] = $ob->GetFields();
            }

            foreach ($arFields as $key => $row) {
                $arFields[$key]['PREVIEW_PICTURE'] = CFile::ResizeImageGet($row["PREVIEW_PICTURE"],
                    ["width" => 700, "height" => 500], BX_RESIZE_IMAGE_PROPORTIONAL);
            }

            return $arFields;
        }

        return [];
    }
}