<?php

namespace Letsrock\Bonus;

use Bitrix\Sale\Order;

/**
 * Class Withdraw
 *
 * @package Bonus\Lib\Models
 */
class Withdraw extends Transaction
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
        $price = $order->getPrice();
        $bonus = $this->getBonusCountByMoney($price);
        Helper::changeBonusInUser($userId, $bonus, false);

        return parent::__construct([
            'UF_SIGN' => 0,
            'UF_BONUS' => $bonus,
            'UF_USER' => $userId,
            'UF_ORDER' => $orderId,
        ], $userId);
    }
}