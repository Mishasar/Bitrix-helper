<?php

namespace Letsrock\Lib\Models;

use Bitrix\Main\Loader;
use CIBlockElement;

/*
 * Class VideoGallery
 */

class VideoGallery
{
    /**
     * Возвращает видео с youtube
     *
     * @return array
     * @throws \Bitrix\Main\LoaderException
     */
    function getAll()
    {
        if (Loader::includeModule('iblock')) {
            $videoList = [];
            $arSelect = [
                "ID",
                "NAME",
                "PROPERTY_LINK",
            ];

            $arFilter = [
                "IBLOCK_ID" => IntVal(IB_VIDEO),
                "ACTIVE" => "Y"
            ];

            $res = CIBlockElement::GetList(["SORT" => "ASC"], $arFilter, false, ["nPageSize" => 10], $arSelect);
            $arFields = [];

            while ($ob = $res->GetNextElement()) {
                $fields = $ob->GetFields();
                $link = $fields['PROPERTY_LINK_VALUE'];
                $videoId = explode("?v=", $link);
                $videoId = $videoId[1];
                $thumbnail = "http://img.youtube.com/vi/" . $videoId . "/maxresdefault.jpg";
                $videoList[] = [
                    'URL' => 'https://www.youtube.com/embed/' . $videoId . "?enablejsapi=1&amp;controls=0&amp;fs=0&amp;iv_load_policy=3&amp;rel=0&amp;showinfo=0&amp;loop=1&amp;start=1",
                    'PICTURE' => $thumbnail,
                    'NAME' => $fields['NAME']
                ];
            }

            return $videoList;
        }

        return [];
    }
}