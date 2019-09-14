<?php

namespace App\Order\Factory;

use Psr\Container\ContainerInterface;
use Psr\Http\Server\RequestHandlerInterface;
use App\Order\GetAll as Action;
use App\Repository\Customer;
use App\Repository\Order;
use App\Repository\Product;

class GetAll
{
    public function __invoke(ContainerInterface $container):RequestHandlerInterface
    {
        $mongo = $container->get('mongo');
        $jms = $container->get('jms');

        return new Action(
            new Order($mongo, $jms),
            new Customer($mongo, $jms),
            new Product($mongo, $jms),
            $container->get('jms')
        );
    }
}
