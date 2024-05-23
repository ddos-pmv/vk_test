<?php


interface OrderServiceInterface
{
    public function createOrder(int $userId, array $items): Order;

    public function getOrderStatus(int $orderId): string;

    public function cancelOrder(int $orderId): bool;
}

class OrderService implements OrderServiceInterface
{
    public function createOrder(int $userId, array $items): Order
    {
        //Создание заказа
        //Изменнения в бд
        //Отпрака даннх внешним системам
    }

    public function getOrderStatus(int $orderId): string
    {
        //Полученик статуса заказа от внешних систем
    }

    public function cancelOrder(int $orderId): bool
    {
        //Отмена заказа
    }
}

class Order
{
    private $orderId;
    private $userId;
    private $items;
    private $status;
    private $createdAt;

}

