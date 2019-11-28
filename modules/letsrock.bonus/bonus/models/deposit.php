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
     * Deposit constructor.
     *
     * @param int $userId
     * @param int $orderId
     */
    public function __construct(int $userId, int $orderId)
    {
        try {
            parent::__construct($userId);

            $order = Order::load($orderId);
            $dataInsert = $order->getDateInsert();
            $price = $order->getPrice();
            $bonus = $this->getBonusCountByPrice($price);
            Helper::changeBonusInUser($userId, $bonus);
            $resultAddTransaction = $this->createTransaction([
                'UF_SIGN' => 1,
                'UF_BONUS' => $bonus,
                'UF_USER' => $userId,
                'UF_ORDER' => $orderId,
                'UF_DATE' => $dataInsert->toString()
            ]);

            return $resultAddTransaction;
        } catch (\Exception $e) {
            AddMessage2Log($e->getMessage(), "letsrock.bonus");
            return false;
        }
    }
}