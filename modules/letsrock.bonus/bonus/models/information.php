<?php


namespace Letsrock\Bonus;

/**
 * Class Information
 *
 * @package Letsrock\Bonus
 */
class Information extends Core
{
    /**
     * Information constructor.
     *
     * @param int $userId
     */
    public function __construct(int $userId)
    {
        parent::__construct($userId);
    }

    /**
     * Возвращает количество бонусов пользователя
     *
     * @return mixed
     */
    public function getCountBonuses()
    {
        try {
            $result = \Bitrix\Main\UserTable::getList([
                'select' => ['NAME', 'ID', 'UF_BONUS'],
                'filter' => ['=ID' => $this->userId]
            ]);

            $arUser = $result->fetch();

            return $arUser['UF_BONUS'];
        } catch (\Exception $e) {
            return 0;
        }
    }

    /**
     * Возвращает массив бонусов (см. функцию Core::setBonusesStructure)
     *
     * @return mixed
     */
    public function getBonusesStructure() {
        return $this->bonusSystemByMonth;
    }
}