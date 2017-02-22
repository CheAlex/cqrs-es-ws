<?php

namespace Shop\Product\Command;

use Shop\Product\ValueObject\ProductId;

class UpdateProduct
{
    /**
     * @var ProductId
     */
    private $productId;
    private $size;
    /**
     * @var \DateTimeImmutable
     */
    private $updatedAt;

    public function __construct(
        ProductId $productId,
        $size,
        \DateTimeImmutable $updatedAt
    ) {
        $this->productId    = $productId;
        $this->size         = $size;
        $this->updatedAt = $updatedAt;
    }

    /**
     * @return ProductId
     */
    public function getProductId(): ProductId
    {
        return $this->productId;
    }

    /**
     * @return mixed
     */
    public function getSize()
    {
        return $this->size;
    }

    /**
     * @return \DateTimeImmutable
     */
    public function getUpdatedAt(): \DateTimeImmutable
    {
        return $this->updatedAt;
    }
}