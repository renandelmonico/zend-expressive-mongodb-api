<?php

namespace App\Order;

use App\Entity\Order as Entity;
use App\Entity\Order\Buyer;
use App\Entity\Order\Item;
use App\Repository\Order;
use JMS\Serializer\Serializer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Zend\Diactoros\Response\JsonResponse;
use App\Helper\Validator as ValidatorHelper;
use App\Repository\Customer;
use App\Repository\Product;

class Post implements RequestHandlerInterface
{
    /**
     * Repositorio de pedidos
     *
     * @var Order
     */
    private $Order;

    /**
     * Repositorio de clientes
     *
     * @var Customer
     */
    private $Customer;

    /**
     * Repositorio de produtos
     *
     * @var Product
     */
    private $Product;

    /**
     * JMS
     *
     * @var Serializer
     */
    private $JMS;

    /**
     * Validator
     *
     * @var ValidatorInterface
     */
    private $Validator;

    /**
     * Construtor
     *
     * @param Order $Order
     * @param Customer $Customer
     * @param Product $Product
     * @param Serializer $JMS
     * @param ValidatorInterface $Validator
     */
    public function __construct(
        Order $Order,
        Customer $Customer,
        Product $Product,
        Serializer $JMS,
        ValidatorInterface $Validator
    ) {
        $this->Order = $Order;
        $this->Customer = $Customer;
        $this->Product = $Product;
        $this->JMS = $JMS;
        $this->Validator = $Validator;
    }

    public function handle(ServerRequestInterface $request):ResponseInterface
    {
        $Entity = $this->JMS->deserialize(
            $request->getBody()->getContents(),
            Entity::class,
            'json'
        );

        $Entity->setCreatedAt(new \DateTime('now'));

        $validacao = $this->Validator->validate($Entity);
        $areValidBuyerAndProducts = $this->buyerAndProductsValidator($Entity);

        if ($validacao->count() || !empty($areValidBuyerAndProducts)) {
            return new JsonResponse(
                array_merge(
                    ValidatorHelper::getMessageArray($validacao),
                    $areValidBuyerAndProducts
                ),
                400
            );
        }

        $id = $this->Order->insert($Entity);

        return new JsonResponse(
            [ '_id' => (string) $id ],
            201
        );
    }

    private function buyerAndProductsValidator(Entity $Order):array
    {
        $violations = [];

        if (!$this->isValidBuyer($Order->getBuyer())) {
            $violations[] = 'Cliente não existe';
        }

        foreach ($Order->getItems() as $Item) {
            if (!$Item->getProduct()) {
                continue;
            }

            if (!$this->isValidProduct($Item)) {
                $violations[] = 'Produto não existe';
                break;
            }
        }

        if (!$this->uniqueProducts($Order->getItems())) {
            $violations[] = 'Há produtos duplicados';
        }

        return $violations;
    }

    private function isValidBuyer(Buyer $Buyer):bool
    {
        return !empty($this->Customer->find([
            '_id' => $Buyer->getId()
        ]));
    }

    private function isValidProduct(Item $Item):bool
    {
        return !empty($this->Product->find([
            '_id' => $Item->getProduct()->getId()
        ]));
    }

    private function uniqueProducts(array $products):bool
    {
        $products = array_count_values(array_map(function ($it) {
            return (string) $it->getProduct()->getId();
        }, $products));

        $duplicatedProducts = array_filter($products, function ($it) {
            return $it > 1;
        });

        return !count($duplicatedProducts);
    }
}
