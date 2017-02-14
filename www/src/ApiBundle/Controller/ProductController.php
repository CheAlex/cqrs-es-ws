<?php

namespace ApiBundle\Controller;

use Shop\Product\Command\CreateProduct;
use Shop\Product\ReadModel\Product;
use Shop\Product\ValueObject\ProductId;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class ProductController extends Controller
{
    public function createAction(Request $request)
    {
        $productId = new ProductId($this->get('shop.service.uuid_generator')->generate());

        $createProduct = new CreateProduct(
            $productId,
            '5707055029608',
            'Nome prodotto: Scaaarpe',
            'http://static.politifact.com.s3.amazonaws.com/subjects/mugs/fake.png',
            'Brand prodotto: Super Scaaaarpe',
            new \DateTimeImmutable('2017-02-14')
        );

        $this->get('broadway.command_handling.simple_command_bus')->dispatch($createProduct);

        return new JsonResponse(['product_id' => (string)$productId], 201);
    }

    public function getAction(Request $request)
    {
        /** @var Product $productReadModel */
        $productReadModel = $this->get('shop.product.read_model.repository')->find(new ProductId($request->get('id')));

        return new JsonResponse($productReadModel->serialize());
    }
}
