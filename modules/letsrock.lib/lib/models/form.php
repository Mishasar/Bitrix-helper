<?php

namespace Letsrock\Lib\Models;

use Bitrix\Main\Loader;
use Bitrix\Main\Mail\Event;


Loader::includeModule('iblock');

/*
 * Class Form
 * Класс для работы с формами
 */

class Form
{
    private $iblockId = 0;

    public function __construct($id)
    {
        $this->iblockId = $id;
    }

    function addMainForm($fields)
    {
        global $USER;
        $themes = [
            1 => 'Клиентские рассылки',
            2 => 'Рост продаж',
            3 => 'Программа лояльности',
            4 => 'Сотрудничество',
            5 => 'Подписка на рассылки'
        ];

        $props = [
            "EMAIL" => $fields['EMAIL'],
            "NAME" => $fields['NAME'],
            "PHONE" => $fields['TEL'],
            "SITE" => $fields['SITE'],
            "COMMENT" => $fields['COMMENT']
        ];

        if (!empty($fields['THEME'])) {
            $props['THEME'] = $themes[$fields['THEME']];
        }

        $el = new \CIBlockElement();
        $arFields = Array(
            "MODIFIED_BY" => $USER->GetID(),
            "ACTIVE" => 'Y',
            "IBLOCK_SECTION_ID" => false,
            "IBLOCK_ID" => $this->iblockId,
            "NAME" => $fields['NAME'],
            "SORT" => 100,
            "PROPERTY_VALUES" => $props,
        );

        $result = $el->Add($arFields);

        $res = Event::send(array(
            "EVENT_NAME" => "FORM_SEND",
            "LID" => "s1",
            "C_FIELDS" => array(
                "P_EMAIL" =>  $props['EMAIL'],
                "P_NAME" =>  $props['NAME'],
                "P_PHONE" =>  $props['PHONE'],
                "P_SITE" =>  $props['SITE'],
                "P_COMMENT" =>  $props['COMMENT'],
                "P_THEME" =>  $props['THEME']
            ),
        ));

        if ($result) {

            return json_encode(
                ['success' => 1]
            );

        } else {

            return json_encode(
                [
                    'success' => 0,
                    'error' => $el->LAST_ERROR
                ]
            );

        };
    }


}