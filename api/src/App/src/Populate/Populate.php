<?php

namespace App\Populate;

use App\Entity\Customer as AppCustomer;
use App\Entity\Order as AppOrder;
use App\Entity\Order\Buyer;
use App\Entity\Order\Product as AppEntityProduct;
use App\Entity\Product as AppProduct;
use App\Model\OrderList\Item;
use App\Repository\Order;
use JMS\Serializer\Serializer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use App\Repository\Customer;
use App\Repository\Product;
use Zend\Diactoros\Response\JsonResponse;

class Populate implements RequestHandlerInterface
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
        Product $Product
    ) {
        $this->Order = $Order;
        $this->Customer = $Customer;
        $this->Product = $Product;
    }

    public function handle(ServerRequestInterface $request):ResponseInterface
    {
        $return = new \stdClass;

        $product = $this->getProduct();
        $customer = $this->getCustomer();
        $order = $this->getOrder();

        $return->product = (string) $this->Product->insert($product);
        $return->customer = (string) $this->Customer->insert($customer);

        $order->buyer = new Buyer;
        $order->buyer->setId($return->customer);
        $order->items[0]->product = new AppEntityProduct;
        $order->items[0]->product->setId($return->product);

        $return->order = (string) $this->Order->insert($order);

        return new JsonResponse($return);
    }

    private function getProduct():AppProduct
    {
        $Product = new AppProduct;
        $Product->setName('Produto');
        $Product->setPrice(99.99);
        $Product->setSku(123456789);
        $Product->setCreatedAt(new \DateTime('now'));

        return $Product;
    }

    private function getCustomer():AppCustomer
    {
        $Customer = new AppCustomer;
        $Customer->setName('Renan');
        $Customer->setEmail('renandelmonico@gmail.com');
        $Customer->setCpf('83901279032');
        $Customer->setCreatedAt(new \DateTime('now'));

        return $Customer;
    }

    private function getOrder():AppOrder
    {
        $Item = new Item;
        $Item->setAmount(1);
        $Item->setPriceUnit(99.99);
        $Item->setTotal(99.99);

        $Order = new AppOrder;
        $Order->setStatus('CONCLUDED');
        $Order->setTotal(99.99);
        $Order->setItems([$Item]);
        $Order->setCreatedAt(new \DateTime('now'));

        return $Order;
    }
}
