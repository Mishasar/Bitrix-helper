<?php

namespace Letsrock\Lib\Models;

/**
 * Класс BonusTransaction
 *
 * @package Letsrock\Lib\Models
 */

class BonusTransaction
{
    protected static function add(array $params)
    {
        $bonusTransactionModel = new HLBlock(HL_BONUS);

        return $bonusTransactionModel->add([
            'UF_SIGN' => $params['SIGN'],
            'UF_BONUS' => $params['BONUS'],
            'UF_USER' => $params['USER'],
            'UF_ORDER' => $params['ORDER'],
        ]);
    }

    /**
     * Зачисление бонусов
     *
     * @param array $params
     *
     * @return bool
     * @throws \Bitrix\Main\ArgumentException
     * @throws \Bitrix\Main\SystemException
     */
    public static function depositBonus(array $params)
    {
        $params['SIGN'] = 1;
        $result = BonusTransaction::add($params);

        if ($result) {
            User::changeBonus($params['USER'], $params['BONUS']);

            return true;
        } else {
            return false;
        }
    }

    /**
     * Снятие бонусов
     *
     * @param array $params
     *
     * @return bool
     * @throws \Bitrix\Main\ArgumentException
     * @throws \Bitrix\Main\SystemException
     */
    public static function withdrawBonus(array $params)
    {
        $params['SIGN'] = 0;
        $result = BonusTransaction::add($params);

        if ($result) {
            User::changeBonus($params['USER'], $params['BONUS'], false);

            return true;
        } else {
            return false;
        }
    }
}