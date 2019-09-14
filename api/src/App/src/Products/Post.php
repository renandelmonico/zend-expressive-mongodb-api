<?php

namespace App\Products;

use App\Entity\Product as Entity;
use App\Repository\Product;
use JMS\Serializer\Serializer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Zend\Diactoros\Response\JsonResponse;
use App\Helper\Validator as ValidatorHelper;

class Post implements RequestHandlerInterface
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
     * Validator
     *
     * @var ValidatorInterface
     */
    private $Validator;

    /**
     * Construtor
     *
     * @param Product $Product
     * @param Serializer $JMS
     * @param ValidatorInterface $Validator
     */
    public function __construct(
        Product $Product,
        Serializer $JMS,
        ValidatorInterface $Validator
    ) {
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
        if ($validacao->count()) {
            return new JsonResponse(
                ValidatorHelper::getMessageArray($validacao),
                400
            );
        }

        if ($this->productExists($Entity->getSku(), $Entity->getName())) {
            return new JsonResponse(
                ['O produto já existe'],
                400
            );
        }

        $id = $this->Product->insert($Entity);

        return new JsonResponse(
            [ '_id' => (string) $id ],
            201
        );
    }

    private function productExists(string $sku, string $name):bool
    {
        return !empty($this->Product->find([
            '$or' => [
                ['sku' => $sku],
                ['name' => $name]
            ]
        ]));
    }
}
