<?php

namespace Letsrock\Lib\Models;

use Bitrix\Main\Loader;
use Bitrix\Main\UserTable;

Loader::includeModule('iblock');


/**
 * Class User
 * Класс для работы с пользователями
 */

class User
{

    /** Метод в разработке
     * @param $email
     * @param $password
     * @param array $array
     * @param null $send
     * @param string $active
     * @param bool $auth
     * @param string $lid
     * @return bool|string
     */
    public static function reg($email, $password, $array = array(), $event = null, $active = 'Y', $auth = true, $lid = 'ru')
    {

        global $USER;

        $user = new \CUser;

        if (empty($email) || empty($password))
            return 'Ошибка! В вызове ' . __METHOD__ . ' отсутствует обязательные параметр email и/или password';

        if (!self::isEmail($email))
            return 'Ошибка! В вызове ' . __METHOD__ . ' неверный формат Email';

        $data = array();

        if(!empty($array))
            $data = Helper::dataFilter($array, false);

        $data['EMAIL'] = $email;
        $data['PASSWORD'] = $password;
        $data['CONFIRM_PASSWORD'] = $password;
        $data['LID'] = $lid;

        $data['ACTIVE'] = $active ? 'Y' : 'N';

        if (empty($data['LOGIN']))
            $data['LOGIN'] = $email;

        // Добавление нового пользователя
        $id = $user->Add($data);

        if (intval($id) > 0) {

            // Отправка почты пользователю
            if (!empty($event))
                Helper::sendEvent($event, $data, $lid);

            // Авторизуем пользователя
            if ($auth)
                $USER->Authorize($id);

            return true;
        } else {
            return $user->LAST_ERROR;

        }

    }

    /**
     * Метод авторизации пользователя в системе
     * @param string $login
     * @param string $pass
     * @param string $remember
     * @return bool
     */
    public static function login($login, $pass, $remember = 'Y')
    {

        $user = new \CUser;
        $arAuthResult = $user->Login($login, $pass, $remember);

        if ($arAuthResult === true)
            return true;
        else
            return false;
    }


    /**
     * Метод проверки существования пользователя в базе. По умолчанию ищет по полю EMAIL.
     * @param string $data
     * @param mixed $filter
     * @param string $by
     * @param string $order
     * @return mixed
     */
    public static function isUser($str, $filter = false)
    {

        if (empty($str) && empty($filter))
            return 'Ошибка! В вызове ' . __METHOD__ . ' отсутствует обязательные параметр str или filter';

        if (!$filter)
            $filter = Array("EMAIL" => $str);

        $users = \CUser::GetList(($by = 'NAME'), ($order = 'DESC'), $filter);
        if ($userData = $users->Fetch())
            return $userData;


        return false;

    }

    /**
     * Метод-обертка для метода isUser, для поиска пользователя по Email
     * @param $str
     * @return mixed
     */
    public static function isUserEmail($str)
    {
        return self::isUser(false, array('EMAIL' => $str));
    }

    /**
     * Метод-обертка для метода isUser, для поиска пользователя по номеру логину
     * @param $str
     * @return mixed
     */

    /**
     * Метод-обертка для метода isUser, для поиска пользователя по номеру телефона
     * @param $str
     * @return mixed
     */
    public static function isUserPhone($str)
    {
        return self::isUser(false, array('PERSONAL_PHONE' => $str));
    }

    /**
     * Метод-обертка для метода isUser, для поиска пользователя по номеру логину
     * @param $str
     * @return mixed
     */

    public static function isUserLogin($str)
    {
        return self::isUser(false, array('LOGIN' => $str));
    }


    /**
     * Метод проверки EMAIL на валидность
     * @param $email
     * @return bool
     */
    public static function isEmail($email)
    {
        if (filter_var($email, FILTER_VALIDATE_EMAIL))
            return true;
        else
            return false;

    }

    /**
     * Изменяет количество бонусов у пользователя
     *
     * @param $id
     * @param $bonusCount
     * @param bool $add
     *
     * @throws \Bitrix\Main\ArgumentException
     * @throws \Bitrix\Main\SystemException
     */
    public static function changeBonus($userId, $bonusCount, $add = true) {
        $user = UserTable::getEntity($userId);
        $currentBonusCount = $user->getField('UF_BONUS');

        if ($add) {
            $currentBonusCount += $bonusCount;
        } else {
            $currentBonusCount -= $bonusCount;

        }

        $user->setField('UF_BONUS', $currentBonusCount);
    }

    /**
     * Возвращает информацию о прикреплённом менеджере текущего пользователя
     *
     * @param bool $userId
     *
     * @return array|bool
     */

    public static function getManager($userId = false)
    {
        global $USER;

        if ($USER->IsAuthorized()) {
            if (!$userId) {
                $userId = $USER->GetID();
            }

            $userInfo = \CUser::GetByID($userId)->GetNext();
            $managerId = $userInfo['UF_MANAGER'];

            if ($managerId) {
                $arResult = \CUser::GetByID($managerId)->GetNext();
                return $arResult;
            }

            return false;
        }
        return false;
    }
}



