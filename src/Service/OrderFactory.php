<?php

declare(strict_types=1);

namespace App\Service;


use App\Entity\Order;
use App\Entity\OrderItem;
use App\Entity\Product;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\EventDispatcher\GenericEvent;

class OrderFactory 
{
    /**
     * @var OrderSessionStorage
     */
    private $storage;

    /**
     * @var Order
     */
    private $order;

    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * @var EventDispatcherInterface
     */
    private $eventDispatcher;

    public function __construct(OrderSessionStorage $storage, EntityManagerInterface $entityManager, EventDispatcherInterface $eventDispatcher)
    {
        $this->storage = $storage;
        $this->entityManager = $entityManager;
        $this->eventDispatcher = $eventDispatcher;
        $this->order = $this->getCurrent();
    }

    /**
     * {@inheritdoc}
     */
    public function getCurrent(): Order
    {
        $order = $this->storage->getOrderById();
        if ($order !== null) {
            return $order;
        }

        return new Order();
    }

    /**
     * {@inheritdoc}
     */
    public function addItem(Product $product, int $quantity): void
    {
        $orderBeforeId = $this->order->getId();
        if (!$this->containsProduct($product)) {
            $orderItem = new OrderItem();
            $orderItem->setItemOrder($this->order);
            $orderItem->setProduct($product);
            $orderItem->setQuantity($quantity);
            $this->order->addOrderItem($orderItem);
        } else {
            $key = $this->indexOfProduct($product);
            $item = $this->order->getOrderItem()->get($key);
            $quantity = $this->order->getOrderItem()->get($key)->getQuantity() + 1;
            $this->setItemQuantity($item, $quantity);
        }

        $this->entityManager->persist($this->order);
        $this->entityManager->flush();
  
        // Run events
        if ($orderBeforeId === null) {
            $event = new GenericEvent($this->order);
            $this->eventDispatcher->dispatch(Events::ORDER_CREATED, $event);
        } else {
            $event = new GenericEvent($this->order);
            $this->eventDispatcher->dispatch(Events::ORDER_UPDATED, $event);
        }
        $this->entityManager->flush();
        
    }

    /**
     * {@inheritdoc}
     */
    public function containsProduct(Product $product): bool
    {
        foreach ($this->order->getOrderItem() as $item) {

            if ($item->getProduct() === $product) {
                return true;
            }
        }

        return false;
    }

    /**
     * {@inheritdoc}
     */
    public function indexOfProduct(Product $product): ?int
    {
        foreach ($this->order->getOrderItem() AS $key => $item) {
            if ($item->getProduct() === $product) {
                return $key;
            }
        }

        return null;
    }

    /**
     * {@inheritdoc}
     */
    public function setItemQuantity(OrderItem $item, int $quantity): void
    {
        if ($this->order && $this->order->getOrderItem()->contains($item)) {
            $key = $this->order->getOrderItem()->indexOf($item);

            $item->setQuantity($quantity);

            $this->order->getOrderItem()->set($key, $item);

            // Run events
            $event = new GenericEvent($this->order);
            $this->eventDispatcher->dispatch(Events::ORDER_UPDATED, $event);

            $this->entityManager->persist($this->order);
            $this->entityManager->flush();
        }
    }

    /**
     * {@inheritdoc}
     */
    public function removeItem(OrderItem $item): void
    {
        if ($this->order && $this->order->getOrderItem()->contains($item)) {
            $this->order->removeOrderItem($item);

            // Run events
            $event = new GenericEvent($this->order);
            $this->eventDispatcher->dispatch(Events::ORDER_UPDATED, $event);

            $this->entityManager->persist($this->order);
            $this->entityManager->flush();
        }
    }

    /**
     * {@inheritdoc}
     */
    public function items(): Collection
    {
        return $this->order->getOrderItem();
    }

    /**
     * {@inheritdoc}
     */
    public function updateBindings(): void
    {    
        if ($this->order) {

            // Run events
          //  $event = new GenericEvent($this->order);
           // $this->eventDispatcher->dispatch(Events::ORDER_UPDATED, $event);

            $this->entityManager->persist($this->order);
            $this->entityManager->flush();
        }
    }

    

    /**
     * {@inheritdoc}
     */
    public function clear(): void
    {
        $this->entityManager->remove($this->order);
        $this->entityManager->flush();
    }

    /**
     * {@inheritdoc}
     */
    public function isEmpty(): bool
    {
        return !$this->order->getItems();
    }

   
}