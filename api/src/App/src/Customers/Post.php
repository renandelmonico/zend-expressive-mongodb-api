<?php

namespace App\Customers;

use App\Entity\Customer as Entity;
use App\Repository\Customer;
use JMS\Serializer\Serializer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Zend\Diactoros\Response\JsonResponse;
use App\Helper\Validator as ValidatorHelper;
use Symfony\Component\Validator\ConstraintViolation;
use Symfony\Component\Validator\ConstraintViolationList;

class Post implements RequestHandlerInterface
{
    /**
     * Repositorio de cliente
     *
     * @var Customer
     */
    private $Customer;

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
     * @param Customer $Customer
     * @param Serializer $JMS
     * @param ValidatorInterface $Validator
     */
    public function __construct(
        Customer $Customer,
        Serializer $JMS,
        ValidatorInterface $Validator
    ) {
        $this->Customer = $Customer;
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

        if ($this->customerExists($Entity->getCpf(), $Entity->getEmail())) {
            return new JsonResponse(
                ['Cliente já existe'],
                400
            );
        }

        $id = $this->Customer->insert($Entity);

        return new JsonResponse(
            [ '_id' => (string) $id ],
            201
        );
    }

    private function customerExists(string $cpf, string $email)
    {
        return !empty($this->Customer->find([
            '$or' => [
                ['cpf' => $cpf],
                ['email' => $email]
            ]
        ]));
    }
}
