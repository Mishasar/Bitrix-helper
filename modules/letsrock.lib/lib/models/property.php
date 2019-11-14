<?php

namespace Letsrock\Lib\Models;

use Bitrix\Main\Loader;

Loader::includeModule('iblock');


/*
 * Class Property
 * Класс для работы с настройками
 */

class Property
{
    private function __construct()
    {
        Loader::IncludeModule("iblock");
    }

    public static function getText($code)
    {
        return Property::get($code, false, true)['TEXT'];
    }

    public static function getImage($code)
    {
        return Property::get($code, true, false)['PICTURE'];

    }

    public static function getFile($code)
    {
        return Property::get($code, false, false, true)['FILE'];

    }

    public static function get($code, $image = true, $text = true, $file = false)
    {
        $result = [];
        $arSelect = [
            "ID",
            "NAME"
        ];

        if ($image) {
            $arSelect[] = "PREVIEW_PICTURE";
        }

        if ($text) {
            $arSelect[] = "PREVIEW_TEXT";
        }

        if ($file) {
            $arSelect[] = "PROPERTY_FILE";
        }

        $arFilter = ["IBLOCK_ID" => IntVal(IB_PROPS), "ACTIVE" => "Y", 'CODE' => $code];
        $res = \CIBlockElement::GetList(["SORT" => "ASC"], $arFilter, false, ["nPageSize" => 1], $arSelect);
        $ob = $res->GetNextElement();
        if ($ob) {
            $arFields = $ob->GetFields();

            if ($image) {
                $result['PICTURE'] = \CFile::ResizeImageGet($arFields["PREVIEW_PICTURE"],
                    ["width" => 1920, "height" => 1080], BX_RESIZE_IMAGE_PROPORTIONAL);
            }

            if ($text) {
                $result['TEXT'] = $arFields["PREVIEW_TEXT"];
            }

            if ($file) {
                $result['FILE'] = \CFile::GetPath($arFields["PROPERTY_FILE_VALUE"]);
            }

            return $result;
        }

        return ['TEXT' => "", "PICTURE" => "", "FILE" => ""];
    }
}
