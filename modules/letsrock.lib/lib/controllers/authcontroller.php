<?php

namespace Letsrock\Lib\Controllers;

/**
 * Class authController
 * Контроллер авторизации
 */
class authController extends Controller
{
    /**
     * AJAX
     *
     * @param $request
     */
    public function auth($request)
    {
        global $USER;
        $arAuthResult = $USER->Login($request['email'], $request['password'], "N");

        if (isset($arAuthResult['TYPE']) && $arAuthResult['TYPE'] == 'ERROR') {
            echo Controller::sendError($arAuthResult['MESSAGE']);
        } else {
            echo Controller::sendAnswer([
                'msg' => 'Вы успешно авторизованы!'
            ]);
        }
    }

    /**
     * HOOK
     * Проверяем пришел ли email или login и если email авторизуем по нему
     *
     * @param $arFields
     */
    function DoBeforeUserLoginHandler(&$arFields)
    {
        $userLogin = $_POST["USER_LOGIN"];
        if (isset($userLogin)) {
            $isEmail = strpos($userLogin, "@");
            if ($isEmail > 0) {
                $arFilter = ["EMAIL" => $userLogin];
                $rsUsers = CUser::GetList(($by = "id"), ($order = "desc"), $arFilter);

                if ($res = $rsUsers->Fetch()) {
                    if ($res["EMAIL"] == $arFields["LOGIN"]) {
                        $arFields["LOGIN"] = $res["LOGIN"];
                    }
                }
            }
        }
    }
}