<?php

namespace Shop\Product\Event;

use Broadway\Serializer\SerializableInterface;
use Shop\Product\ValueObject\ProductId;

class ProductUpdated implements SerializableInterface
{
    /**
     * @var ProductId
     */
    private $productId;
    /**
     * @var string
     */
    private $size;
    /**
     * @var \DateTimeImmutable
     */
    private $updatedAt;

    public function __construct(
        ProductId $productId,
        string $size,
        \DateTimeImmutable $updatedAt
    ) {
        $this->productId = $productId;
        $this->size      = $size;
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
     * @return string
     */
    public function getSize(): string
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

    /**
     * @param array $data
     *
     * @return mixed The object instance
     */
    public static function deserialize(array $data)
    {
        return new self(
            new ProductId($data['productId']),
            $data['size'],
            new \DateTimeImmutable($data['updatedAt'])
        );
    }

    /**
     * @return array
     */
    public function serialize()
    {
        return [
            'productId' => (string)$this->productId,
            'size'      => $this->size,
            'updatedAt' => $this->updatedAt->format('Y-m-d\TH:i:s.uP')
        ];
    }
}
