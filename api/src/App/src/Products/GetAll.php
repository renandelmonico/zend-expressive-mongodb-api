<?php

namespace App\Products;

use App\Entity\Product as Entity;
use App\Helper\Response\JMSJsonResponse;
use App\Repository\Product;
use JMS\Serializer\Serializer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Zend\Diactoros\Response\JsonResponse;
use App\Helper\Validator as ValidatorHelper;
use MongoDB\BSON\ObjectId;

class GetAll implements RequestHandlerInterface
{
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
     * @param Product $Product
     * @param Serializer $JMS
     */
    public function __construct(
        Product $Product,
        Serializer $JMS
    ) {
        $this->Product = $Product;
        $this->JMS = $JMS;
    }

    public function handle(ServerRequestInterface $request):ResponseInterface
    {
        return new JMSJsonResponse(
            $this->JMS,
            $this->Product->findAll(),
            200
        );
    }
}
