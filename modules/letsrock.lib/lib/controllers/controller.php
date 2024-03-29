<?php

namespace Letsrock\Lib\Controllers;

use Bitrix\Main\Loader;
use Letsrock\Lib\Models\Form;

Loader::includeModule('iblock');

/*
 * Class authController
 * Базовый класс контроллера
 */

abstract class Controller
{
    /**
     * Стандартный ответ с ошибкой
     *
     * @param string $message
     *
     * @return false|string
     */
    static function sendError(string $message = "")
    {
        return json_encode(
            [
                'success' => 0,
                'error' => $message
            ]
        );
    }

    /**
     * Стандартный ответ
     *
     * @param array $result
     *
     * @return false|string
     */
    static function sendAnswer(array $result = [])
    {
        return json_encode(
            [
                'success' => 1,
                'data' => $result
            ]
        );
    }
}