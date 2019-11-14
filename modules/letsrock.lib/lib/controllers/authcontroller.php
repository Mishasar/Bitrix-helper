<?php

namespace Letsrock\Lib\Controllers;

/*
 * Class authController
 * Контроллер авторизации
 */

class authController extends Controller
{
    public function auth($request)
    {
        global $USER;
        $arAuthResult = $USER->Login($request['email'], $request['password'], "N");

        if(isset($arAuthResult['TYPE']) && $arAuthResult['TYPE'] == 'ERROR')
        {
            echo Controller::sendError($arAuthResult['MESSAGE']);
        }
        else
        {
            echo Controller::sendAnswer([
                'msg' => 'Вы успешно авторизованы!'
            ]);
        }
    }
}