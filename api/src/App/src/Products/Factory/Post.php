<?php

namespace App\Products\Factory;

use Psr\Container\ContainerInterface;
use Psr\Http\Server\RequestHandlerInterface;
use App\Products\Post as Action;
use App\Repository\Product;

class Post
{
    public function __invoke(ContainerInterface $container):RequestHandlerInterface
    {
        return new Action(
            new Product(
                $container->get('mongo'),
                $container->get('jms')
            ),
            $container->get('jms'),
            $container->get('validator')
        );
    }
}
