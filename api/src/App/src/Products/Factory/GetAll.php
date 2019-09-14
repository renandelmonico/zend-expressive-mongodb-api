<?php

namespace App\Products\Factory;

use Psr\Container\ContainerInterface;
use Psr\Http\Server\RequestHandlerInterface;
use App\Products\GetAll as Action;
use App\Repository\Product;

class GetAll
{
    public function __invoke(ContainerInterface $container):RequestHandlerInterface
    {
        return new Action(
            new Product(
                $container->get('mongo'),
                $container->get('jms')
            ),
            $container->get('jms')
        );
    }
}
