<?php

namespace Letsrock\Lib\Models;

use Bitrix\Main\Loader;
use CFile;
use CIBlockElement;

/*
 * Class Advantages
 */

class Advantages
{
    /**
     * Возвращает все слайды
     *
     * @return array
     * @throws \Bitrix\Main\LoaderException
     */
    function getAll($sectionId = false)
    {
        if (Loader::includeModule('iblock')) {
            $arSelect = [
                "ID",
                "NAME",
            ];

            $arFilter = [
                "IBLOCK_ID" => IntVal(IB_ADVANTAGES),
                "ACTIVE" => "Y"
            ];

            if ($sectionId) {
                $arFilter['SECTION_ID'][0] = $sectionId;
                $nav = \CIBlockSection::GetNavChain(false, $sectionId);

                while ($res = $nav->ExtractFields("nav_")) {
                    if (!empty($res['IBLOCK_SECTION_ID'])) {
                        $arFilter['SECTION_ID'][] = $res['IBLOCK_SECTION_ID'];
                    }
                }
            } else {
                $arFilter['SECTION_ID'] = false;
            }

            $res = CIBlockElement::GetList(["IBLOCK_SECTION_ID " => "DESC"], $arFilter, false, ["nPageSize" => 4], $arSelect);
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