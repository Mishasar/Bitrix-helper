<?php

namespace Letsrock\Bonus;

/**
 * Контроллер бонусов
 *
 * Class BonusSystemController
 *
 * @package Bonus\Lib\Controllers
 */
class Controller
{
    /**
     * Обработчик события смены статуса
     *
     * @param \Bitrix\Main\Event $event
     *
     * @return \Bitrix\Main\EventResult
     */
    public static function orderBonusHandler(\Bitrix\Main\Event $event)
    {
        $parameters = $event->getParameters();
        try {
            if ($parameters['VALUE'] === 'F') {

                /** @var \Bitrix\Sale\Order $order */
                $order = $parameters['ENTITY'];
                $transaction = new Deposit($order);

                return new \Bitrix\Main\EventResult(
                    \Bitrix\Main\EventResult::SUCCESS
                );

            } elseif ($parameters['VALUE'] === 'X' && $parameters['OLD_VALUE'] === 'F') {
//                /** @var \Bitrix\Sale\Order $order */ //TODO: узнать у заказчика про отмену зачисленных бонусов
//                $order = $parameters['ENTITY'];
//                $transaction = new Deposit($order, true);
//
//                return new \Bitrix\Main\EventResult(
//                    \Bitrix\Main\EventResult::SUCCESS
//                );
            }

        } catch (\Exception $e) {
            AddMessage2Log($e->getMessage(), "letsrock.bonus");
        }

        return new \Bitrix\Main\EventResult(
            \Bitrix\Main\EventResult::ERROR
        );
    }

    /**
     * Смена статуса для отмененного заказа
     *
     * @param \Bitrix\Main\Event $event
     *
     * @throws \Bitrix\Main\ArgumentException
     */
    public static function OnSaleOrderBeforeSavedHandler(\Bitrix\Main\Event $event)
    {
        /** @var \Bitrix\Sale\Order $order */
        $order = $event->getParameter("ENTITY");

        if (!$order->isNew()) {

            $orderStatus = $order->getField("STATUS_ID");
            if ($order->isCanceled() && ($orderStatus != "X")) {
                $order->setField("STATUS_ID", "X");
                $event->addResult(new \Bitrix\Main\EventResult(
                    \Bitrix\Main\EventResult::SUCCESS,
                    [
                        "RESULT" => $order,
                    ]
                ));
            }

            return;
        }
    }
}