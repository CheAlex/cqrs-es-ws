<?php

namespace Shop\Product\Aggregate;


use Broadway\EventSourcing\EventSourcedAggregateRoot;
use Shop\Product\Command\CreateProduct;
use Shop\Product\Command\UpdateProduct;
use Shop\Product\Event\ProductCreated;
use Shop\Product\Event\ProductUpdated;
use Shop\Product\ValueObject\ProductId;

class Product extends EventSourcedAggregateRoot
{
    /**
     * @var ProductId
     */
    private $productId;
    /**
     * @var string
     */
    private $barcode;
    /**
     * @var string
     */
    private $name;
    /**
     * @var string
     */
    private $imageUrl;
    /**
     * @var string
     */
    private $brand;
    /**
     * @var \DateTimeImmutable
     */
    private $createdAt;

    /**
     * @param CreateProduct $command
     *
     * @return Product
     */
    public static function create(CreateProduct $command) : Product
    {
        $product = new self();
        $product->apply(
            new ProductCreated(
                $command->getProductId(),
                $command->getBarcode(),
                $command->getName(),
                $command->getImageurl(),
                $command->getBrand(),
                $command->getRegisteredAt()
            )
        );

        return $product;
    }

    public function update(UpdateProduct $command)
    {
        if ($command->getSize() != 'XL' &&
            $command->getSize() != 'L' &&
            $command->getSize() != 'M'
        ) {
            throw new \DomainException();
        }

        $this->apply(
            new ProductUpdated(
                $command->getProductId(),
                $command->getSize(),
                $command->getUpdatedAt()
            )
        );
    }

    protected function applyProductCreated(ProductCreated $event)
    {
        $this->productId = $event->getProductId();
        $this->barcode = $event->getBarcode();
        $this->name = $event->getName();
        $this->imageUrl = $event->getImageurl();
        $this->brand = $event->getBrand();
        $this->createdAt = $event->getCreatedAt();
    }

    /**
     * @return string
     */
    public function getAggregateRootId()
    {
        return $this->productId;
        // TODO: Implement getAggregateRootId() method.
    }
}