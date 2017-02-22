<?php

namespace Tests\Shop\Product\ValueObject;

use Broadway\CommandHandling\CommandHandlerInterface;
use Broadway\CommandHandling\Testing\CommandHandlerScenarioTestCase;
use Broadway\EventHandling\EventBusInterface;
use Broadway\EventStore\EventStoreInterface;
use Shop\Product\Command\UpdateProduct;
use Shop\Product\Event\ProductCreated;
use Shop\Product\Event\ProductUpdated;
use Shop\Product\ProductCommandHandler;
use Shop\Product\Repository;
use Shop\Product\ValueObject\ProductId;

class UpdateProductTest extends CommandHandlerScenarioTestCase
{
    /**
     * @test
     */
    public function should_update_a_product()
    {
        $productId = new ProductId('00000000-0000-0000-0000-000000000321');

        $updatedAt = new \DateTimeImmutable('2017-02-21');
        $this->scenario
            ->withAggregateId($productId)
            ->given([
                new ProductCreated(
                    $productId,
                    '1234567890123',
                    'cool product',
                    'http://fake.com',
                    'Ideato',
                    $updatedAt
                )
            ])
            ->when(
                new UpdateProduct(
                    $productId,
                    'XL',
                    $updatedAt
                )
            )
            ->then(
                [
                    new ProductUpdated(
                        $productId,
                        'XL',
                        $updatedAt
                    )
                ]
            );
    }


    /**
     * @test
     * @expectedException \DomainException
     */
    public function should_not_update_product_when_size_is_wrong()
    {
        $productId = new ProductId('00000000-0000-0000-0000-000000000321');

        $updatedAt = new \DateTimeImmutable('2017-02-21');
        $this->scenario
            ->withAggregateId($productId)
            ->given([
                new ProductCreated(
                    $productId,
                    '1234567890123',
                    'cool product',
                    'http://fake.com',
                    'Ideato',
                    $updatedAt
                )
            ])
            ->when(
                new UpdateProduct(
                    $productId,
//                    'XL',
                    'WRONG SIZE',
                    $updatedAt
                )
            )
        ;
    }

    /**
     * Create a command handler for the given scenario test case.
     *
     * @param EventStoreInterface $eventStore
     * @param EventBusInterface   $eventBus
     *
     * @return CommandHandlerInterface
     */
    protected function createCommandHandler(EventStoreInterface $eventStore, EventBusInterface $eventBus)
    {
        $repository = new Repository($eventStore, $eventBus);

        return new ProductCommandHandler($repository);
    }
}
