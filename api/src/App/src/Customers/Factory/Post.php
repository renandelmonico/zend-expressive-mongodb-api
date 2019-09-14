<?php

namespace App\Customers\Factory;

use Psr\Container\ContainerInterface;
use Psr\Http\Server\RequestHandlerInterface;
use App\Customers\Post as Action;
use App\Repository\Customer;

class Post
{
    public function __invoke(ContainerInterface $container):RequestHandlerInterface
    {
        return new Action(
            new Customer(
                $container->get('mongo'),
                $container->get('jms')
            ),
            $container->get('jms'),
            $container->get('validator')
        );
    }
}
