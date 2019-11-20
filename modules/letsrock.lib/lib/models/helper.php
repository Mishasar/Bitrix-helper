<?php

namespace Letsrock\Lib\Models;

use Bitrix\Main\Loader;
use CFile;

Loader::includeModule('iblock');


/*
 * Class Helper
 * Класс-помощник
 */

class Helper
{

    /**
     * Метод-алиас метода класса User::isEmail
     *
     * @param $email
     *
     * @return mixed
     */
    public static function isEmail($email)
    {
        return User::isEmail($email);
    }


    /**
     * Метод для проверки ajax запросов
     *
     * @return bool
     */
    public static function isAjax()
    {
        if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Метод фильтрации входящих данных
     *
     * @param $array
     * @param bool $json
     * @param bool $filter
     * @param bool $up
     *
     * @return array|string
     */
    public static function dataFilter($array, $json = true, $filter = true, $up = true)
    {

        if (empty($array)) {
            return 'Ошибка! В вызове ' . __METHOD__ . ' отсутствуют обязательные параметр array';
        }

        if ($json) {
            $array = json_decode($array, true);
        }

        $data = [];
        foreach ($array as $key => $value) {

            if ($up) {
                $key = strtoupper($key);
            }

            if ($filter) {
                $data[$key] = trim(strip_tags($value));
            } else {
                $data[$key] = $value;
            }
        }

        return $data;

    }

    /**
     * Метод проверки каптчи
     *
     * @param $cWord
     * @param $cSid
     *
     * @return bool
     */
    public static function checkCaptcha($cWord, $cSid)
    {
        global $APPLICATION;

        if ($APPLICATION->CaptchaCheckCode($cWord, $cSid)) {
            return true;
        } else {
            return false;
        }
    }


    /**
     * Метод отправки почтовых событий Bitrix
     *
     * @param string $event
     * @param array $array
     * @param string $lid
     */
    public static function sendEvent($event, $array, $lid)
    {

        $rs = \CEventType::GetList(['TYPE_ID' => $event, 'LID' => $lid]);
        while ($ar = $rs->Fetch()) {
            \CEvent::Send($ar['EVENT_NAME'], $lid, $array);
        }

    }

    /**
     * Перевод времени в нужный формат
     *
     * @param $date
     * @param string $format
     *
     * @return string
     */
    public static function dateFormat($date, $format = 'd m Y')
    {

        if (!empty($date)) {
            return FormatDate($format, MakeTimeStamp($date));
        } else {
            return false;
        }

    }

    /**
     * Метод ресайза изображения
     *
     * @param $image
     * @param null $width
     * @param null $height
     * @param string $type
     *
     * @return bool
     */
    public static function resizeImage($image, $width = 200, $height = 200, $type = 'BX_RESIZE_IMAGE_PROPORTIONAL_ALT')
    {

        if (!empty($image) && (!empty($width) || !empty(height))) {
            $img = \CFile::ResizeImageGet($image, ['width' => $width, 'height' => $height], $type);
            return $img['src'];
        } else {
            return false;
        }

    }

    /**
     * Метод словоформ от кол-ва
     * Пример вызова: wordForm(17, 'товар', 'товара', 'товаров')
     *
     * @param $num
     * @param $form_for_1
     * @param $form_for_2
     * @param $form_for_5
     *
     * @return mixed
     */
    public static function wordForm($num, $form1, $form2, $form5)
    {

        $num = abs($num) % 100;

        $numX = $num % 10;

        if ($num > 10 && $num < 20) {
            return $form5;
        }

        if ($numX > 1 && $numX < 5) {
            return $form2;
        }

        if ($numX == 1) {
            return $form1;
        }

        return $form5;
    }

    /**
     * Метод форматирования цены
     *
     * @param $number
     *
     * @return string
     */
    public static function priceFormat($number)
    {
        return number_format($number, 0, ',', ' ');
    }


    /**
     * Получить массив изображения по массиву ID
     *
     * @param array $numberArray
     *
     * @return array
     */
    public static function getArrayImages($numberArray, $size = ["width" => 700, "height" => 500])
    {
        $arResult = [];

        foreach ($numberArray as $number) {
            $arResult[$number] = self::getImage($number, $size);
        }

        return $arResult;
    }

    /**
     * Получить изображение по ID
     *
     * @param $number
     * @param array $size
     *
     * @return array|bool|mixed
     */
    public static function getImage($number, $size = ["width" => 700, "height" => 500])
    {
        return CFile::ResizeImageGet($number, $size, BX_RESIZE_IMAGE_PROPORTIONAL);
    }

    /**
     * Возвращает левую границу интервала
     * при поиске в массиве по ключу
     *
     * @param array $array
     * @param int $currentKey
     *
     * @return bool|int|string
     */

    public static function findLeftBorderInArray(array $array, int $currentKey)
    {
        if (empty($array)) {
            return false;
        }

        ksort($array);
        $prevKey = 0;
        $foundKey = 0;
        $iterator = 1;
        $itemsCount = count($array);

        foreach ($array as $key => $item) {
            if ($currentKey >= $key && $iterator < $itemsCount) {
                $foundKey = $prevKey;
                $prevKey = $key;
            } elseif ($currentKey < $key && $iterator == $itemsCount) {
                $foundKey = $prevKey;
                break;
            } elseif ($iterator == $itemsCount) {
                $foundKey = $key;
                break;
            } else {
                $foundKey = $prevKey;
                break;
            }

            $iterator++;
        }

        return $foundKey;
    }
}