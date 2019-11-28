<?php
namespace Letsrock\Bonus;

use Bitrix\Highloadblock\HighloadBlockTable;
use Bitrix\Main\Loader;
use Bitrix\Main\SystemException;

/**
 * Базовый класс транзакции
 *
 * @package Bonus\Lib\Models
 */
abstract class Transaction extends Core
{
    /**
     * Transaction constructor.
     * В качестве аргумента принимает массив параметров со структурой
     *
     * array
     *      ['SIGN']    Знак транзации. Значения 1 обозначает зачисление, 0 спимание.
     *      ['BONUS']   Количество бонусов
     *      ['USER']    Пользователь совершивший или отменивший заказ
     *      ['ORDER']   Номер заказа
     *
     * @param array $params
     * @param int $userId
     *
     * @throws \Bitrix\Main\LoaderException
     */
    public function __construct(array $params, int $userId)
    {
        parent::__construct($userId);

        try {
            Loader::IncludeModule('highloadblock');
            $hlBlock = HighloadBlockTable::getById(self::HL_BONUS_TRANSACTION)->fetch();
            $entity = HighloadBlockTable::compileEntity($hlBlock);
            $entityDataClass = $entity->getDataClass();
            $result = $entityDataClass::add($params);
        } catch (SystemException $e) {
            AddMessage2Log($e->getMessage(), "highloadblock");
            return false;
        }

        return $result->isSuccess();
    }
}