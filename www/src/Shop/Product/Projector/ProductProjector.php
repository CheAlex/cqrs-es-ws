<?php

namespace Shop\Product\Projector;

use Broadway\ReadModel\Projector;
use Broadway\ReadModel\RepositoryInterface;
use Shop\Product\Event\ProductCreated;
use Shop\Product\Event\ProductUpdated;
use Shop\Product\ReadModel\Product;

class ProductProjector extends Projector
{
    private $repository;

    public function __construct(RepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    protected function applyProductCreated(ProductCreated $event)
    {
        $product = new Product();

        $product->setProductId($event->getProductId());
        $product->setBarcode($event->getBarcode());
        $product->setName($event->getName());
        $product->setImageUrl($event->getImageUrl());
        $product->setBrand($event->getBrand());
        $product->setCreatedAt($event->getCreatedAt());

        $this->repository->save($product);
    }

    protected function applyProductUpdated(ProductUpdated $event)
    {
        /** @var Product $product */
        $product = $this->repository->find($event->getProductId());

        $product->setSize($event->getSize());
        $product->setUpdatedAt($event->getUpdatedAt());

        $this->repository->save($product);
    }
}
