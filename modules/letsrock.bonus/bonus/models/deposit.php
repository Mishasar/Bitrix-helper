<?php

namespace Letsrock\Bonus;

use Bitrix\Sale\Order;

/**
 * Class Deposit
 *
 * @package Bonus\Lib\Models
 */
class Deposit extends Transaction
{

    /**
     * Deposit constructor
     *
     * @param Order $order Заказ битрикса
     *
     * @param bool $revert Отмена заказа
     */
    public function __construct(Order $order, $revert = false)
    {
        try {
            $userId = $order->getUserId();
            parent::__construct($userId);
            $dataInsert = $order->getDateInsert();
            $price = $order->getPrice();
            $bonus = $this->getBonusCountByPrice($price);
            Helper::changeBonusInUser($userId, $bonus);
            $sign = $revert ? 0 : 1;

            $resultAddTransaction = $this->createTransaction([
                'UF_SIGN' => $sign,
                'UF_BONUS' => $bonus,
                'UF_USER' => $userId,
                'UF_ORDER' => $order->getId(),
                'UF_DATE' => $dataInsert->toString()
            ]);

            return $resultAddTransaction;
        } catch (\Exception $e) {
            AddMessage2Log($e->getMessage(), "letsrock.bonus");
            return false;
        }
    }
}