<?php

namespace App\Order;

use App\Repository\Order;
use JMS\Serializer\Serializer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Zend\Diactoros\Response\JsonResponse;
use App\Helper\Validator as ValidatorHelper;
use App\Model\OrderStatusUpdate;
use MongoDB\BSON\ObjectId;
use Zend\Diactoros\Response\EmptyResponse;

class Put implements RequestHandlerInterface
{
    /**
     * Repositorio de pedidos
     *
     * @var Order
     */
    private $Order;

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
     * @param Serializer $JMS
     * @param ValidatorInterface $Validator
     */
    public function __construct(
        Order $Order,
        Serializer $JMS,
        ValidatorInterface $Validator
    ) {
        $this->Order = $Order;
        $this->JMS = $JMS;
        $this->Validator = $Validator;
    }

    public function handle(ServerRequestInterface $request):ResponseInterface
    {
        $Entity = $this->JMS->deserialize(
            $request->getBody()->getContents(),
            OrderStatusUpdate::class,
            'json'
        );

        $validacao = $this->Validator->validate($Entity);
        if ($validacao->count()) {
            return new JsonResponse(
                ValidatorHelper::getMessageArray($validacao),
                400
            );
        }

        $order = $this->Order->find([
            '_id' => new ObjectId($request->getAttribute('idorder'))
        ]);

        if (!$order) {
            return new JsonResponse(['Pedido não encontrado'], 400);
        }

        $order = $order[0];

        $order->setStatus($Entity->getStatus());
        $order->setCancelDate(new \DateTime('now'));

        $this->Order->updateById($request->getAttribute('idorder'), $order);

        return new EmptyResponse();
    }
}
