<?php

namespace Letsrock\Bonus;
use \Bitrix\Sale\Order;

/**
 * Class Deposit
 *
 * @package Bonus\Lib\Models
 */
class Deposit extends Transaction
{
    /**
     * Deposit constructor.
     *
     * @param int $userId
     * @param int $orderId
     *
     * @throws \Exception
     */
    public function __construct(int $userId, int $orderId)
    {
        $order = Order::load($orderId);
        $dataInsert = $order->getDateInsert();
        $price = $order->getPrice();
        $bonus = $this->getBonusCountByMoney($price);
        Helper::changeBonusInUser($userId, $bonus);

        return parent::__construct([
            'UF_SIGN' => 1,
            'UF_BONUS' => $bonus,
            'UF_USER' => $userId,
            'UF_ORDER' => $orderId,
            'UF_DATE' => $dataInsert->toString()
        ], $userId);
    }
}