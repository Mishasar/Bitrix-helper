<?php

namespace Letsrock\Lib\Models;

use Bitrix\Main\Loader;
use CFile;
use CIBlockElement;
use CModule;

/*
 * Class TrafficPartner
 */

class TrafficPartner
{
    function getAll($iblockId)
    {
        if (Loader::includeModule('iblock')) {
            $arSelect = [
                "ID",
                "NAME",
                "PREVIEW_PICTURE"
            ];

            $arFilter = ["IBLOCK_ID" => IntVal($iblockId), "ACTIVE_DATE" => "Y", "ACTIVE" => "Y"];
            $res = CIBlockElement::GetList(["SORT" => "ASC"], $arFilter, false, ["nPageSize" => 50], $arSelect);
            $arFields = [];

            while ($ob = $res->GetNextElement()) {
                $arFields[] = $ob->GetFields();
            }

            foreach ($arFields as $key => $row) {
                $arFields[$key]['PREVIEW_PICTURE'] = CFile::ResizeImageGet($row["PREVIEW_PICTURE"],
                    ["width" => 150, "height" => 80], BX_RESIZE_IMAGE_PROPORTIONAL);

                if ($row["PREVIEW_PICTURE"]) {
                    $arFields[$key]['PREVIEW_PICTURE']['src'] = IMG_DEFAULT;
                }
            }

            return $arFields;
        }

        return [];
    }
}