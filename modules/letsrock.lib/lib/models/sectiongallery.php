<?php

namespace Letsrock\Lib\Models;

use Bitrix\Main\Loader;
use CFile;

/**
 * Class SectionGallery
 */

class SectionGallery
{
    /**
     * Возвращает все разделы каталога
     *
     * @return array
     * @throws \Bitrix\Main\LoaderException
     */
    function getAll()
    {
        if (Loader::includeModule('iblock')) {
            $arFields = [];
            $arFilter = ['IBLOCK_ID' => IB_CATALOG, 'GLOBAL_ACTIVE' => 'Y', "<DEPTH_LEVEL" => 2];
            $result = \CIBlockSection::GetList(['UF_SORT_ON_MAIN' => 'asc'], $arFilter, false);

            while ($ob = $result->GetNextElement()) {
                $fields = $ob->GetFields();
                $fields['PICTURE'] = CFile::ResizeImageGet($fields["PICTURE"],
                    ["width" => 700, "height" => 500], BX_RESIZE_IMAGE_PROPORTIONAL);

                $arFields[] = $fields;
            }

            return $arFields;
        }

        return [];
    }
}