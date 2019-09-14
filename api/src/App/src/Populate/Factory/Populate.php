<?php

namespace App\Populate\Factory;

use Psr\Container\ContainerInterface;
use Psr\Http\Server\RequestHandlerInterface;
use App\Populate\Populate as Action;
use App\Repository\Customer;
use App\Repository\Order;
use App\Repository\Product;

class Populate
{
    public function __invoke(ContainerInterface $container):RequestHandlerInterface
    {
        $mongo = $container->get('mongo');
        $jms = $container->get('jms');

        return new Action(
            new Order($mongo, $jms),
            new Customer($mongo, $jms),
            new Product($mongo, $jms)
        );
    }
}
