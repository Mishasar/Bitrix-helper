<?php

namespace Letsrock\Lib\Models;

use Bitrix\Main\Loader;

/**
 * Class Managers
 */
class Managers
{
    /**
     * Возвращает всех менеджеров
     *
     * @return array
     * @throws \Bitrix\Main\ArgumentException
     * @throws \Bitrix\Main\LoaderException
     * @throws \Bitrix\Main\ObjectPropertyException
     * @throws \Bitrix\Main\SystemException
     */
    static public function getAll()
    {
        $arFields = [];

        if (Loader::includeModule('iblock')) {
            $result = \Bitrix\Main\UserGroupTable::getList([
                'filter' => ['GROUP_ID' => GROUP_MANAGER_ID, 'USER.ACTIVE' => 'Y'],
                'select' => [
                    'USER_ID',
                    'NAME' => 'USER.NAME',
                    'LAST_NAME' => 'USER.LAST_NAME',
                    'SECOND_NAME' => 'USER.SECOND_NAME',
                    'PHOTO'=> 'USER.PERSONAL_PHOTO',
                    'PROFESSION'=> 'USER.PERSONAL_PROFESSION',
                    'PHONE'=> 'USER.PERSONAL_PHONE',
                    'EMAIL'=> 'USER.EMAIL'
                ],
                'order' => ['USER.ID' => 'DESC']
            ]);

            while ($arGroup = $result->fetch()) {
                $arFields[] = $arGroup;
            }
        }

        return $arFields;
    }
}