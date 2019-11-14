<?php

namespace Letsrock\Lib\Models;

use Bitrix\Main\Loader;
use CFile;
use CIBlockElement;

/*
 * Class Histories
 */

class Histories
{
    function getAll()
    {
        if (Loader::includeModule('iblock')) {
            $arSelect = [
                "ID",
                "NAME",
                "PREVIEW_PICTURE",
                "PREVIEW_TEXT",
                "PROPERTY_COOL",
            ];

            $arFilter = ["IBLOCK_ID" => IntVal(IB_HISTORIES), "ACTIVE_DATE" => "Y", "ACTIVE" => "Y"];
            $res = CIBlockElement::GetList(["SORT" => "ASC"], $arFilter, false, ["nPageSize" => 50], $arSelect);
            $arFields = [];

            while ($ob = $res->GetNextElement()) {
                $arFields[] = $ob->GetFields();
            }
            foreach ($arFields as $key => $row) {
                $arFields[$key]['PREVIEW_PICTURE'] = CFile::ResizeImageGet($row["PREVIEW_PICTURE"],
                    ["width" => 700, "height" => 600], BX_RESIZE_IMAGE_PROPORTIONAL);
            }

            return $arFields;
        }

        return [];
    }
}