<?php

namespace Letsrock\Lib\Models;

use Bitrix\Main\Loader;
use CFile;
use CIBlockElement;
use CModule;

/*
 * Class Job
 */

class Job
{
    function getAll($topSection, $bottomSection = false)
    {
        if (Loader::includeModule('iblock')) {
            $arResult = [];

            $arSelect = [
                "ID",
                "NAME",
                "PREVIEW_PICTURE",
                "PREVIEW_TEXT",
                "IBLOCK_SECTION_ID"
            ];

            $arFilter = [
                "IBLOCK_ID" => IntVal(IB_JOB),
                "IBLOCK_SECTION_ID" => $topSection,
                "ACTIVE" => "Y"
            ];

            $res = CIBlockElement::GetList(["SORT" => "ASC"], $arFilter, false, ["nPageSize" => 50], $arSelect);
            $arFields = [];

            while ($ob = $res->GetNextElement()) {
                $arFields[] = $ob->GetFields();
            }

            foreach ($arFields as $key => $row) {
                $arFields[$key]['PREVIEW_PICTURE'] = CFile::ResizeImageGet($row["PREVIEW_PICTURE"],
                    ["width" => 700, "height" => 500], BX_RESIZE_IMAGE_PROPORTIONAL);
            }

            $arResult['TOP'] = $arFields;

            if ($bottomSection) {
                $arSelect = [
                    "ID",
                    "NAME",
                    "PREVIEW_PICTURE"
                ];

                $arFilter = [
                    "IBLOCK_ID" => IntVal(IB_JOB),
                    "IBLOCK_SECTION_ID" => $bottomSection,
                    "ACTIVE" => "Y"
                ];

                $res = CIBlockElement::GetList(["SORT" => "ASC"], $arFilter, false, ["nPageSize" => 50], $arSelect);
                $arFields = [];

                while ($ob = $res->GetNextElement()) {
                    $arFields[] = $ob->GetFields();
                }

                foreach ($arFields as $key => $row) {
                    $arFields[$key]['PREVIEW_PICTURE'] = CFile::ResizeImageGet($row["PREVIEW_PICTURE"],
                        ["width" => 500, "height" => 500], BX_RESIZE_IMAGE_PROPORTIONAL);
                }

                $arResult['BOTTOM'] = $arFields;
            }

            return $arResult;
        }

        return [];
    }
}