<?php

namespace App\Order;

use App\Entity\Order as Entity;
use App\Helper\Response\JMSJsonResponse;
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
use MongoDB\BSON\ObjectId;

class GetAll implements RequestHandlerInterface
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
     * Construtor
     *
     * @param Order $Order
     * @param Customer $Customer
     * @param Product $Product
     * @param Serializer $JMS
     */
    public function __construct(
        Order $Order,
        Customer $Customer,
        Product $Product,
        Serializer $JMS
    ) {
        $this->Order = $Order;
        $this->Customer = $Customer;
        $this->Product = $Product;
        $this->JMS = $JMS;
    }

    public function handle(ServerRequestInterface $request):ResponseInterface
    {
        $orders = $this->Order->findAll();

        $orders = array_map(function ($it) {
            $buyer = $it->getBuyer()->getId();
            $it->setBuyer($this->Customer->find(['_id' => $buyer])[0]);

            foreach ($it->getItems() as &$item) {
                $product = $item->getProduct()->getId();
                $item->setProduct($this->Product->find(['_id' => $product])[0]);
            }

            return $it;
        }, $orders);

        return new JMSJsonResponse(
            $this->JMS,
            $orders,
            200
        );
    }
}
