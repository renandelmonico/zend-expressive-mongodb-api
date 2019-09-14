<?php

namespace App\Order\Factory;

use Psr\Container\ContainerInterface;
use Psr\Http\Server\RequestHandlerInterface;
use App\Order\Put as Action;
use App\Repository\Order;

class Put
{
    public function __invoke(ContainerInterface $container):RequestHandlerInterface
    {
        $mongo = $container->get('mongo');
        $jms = $container->get('jms');

        return new Action(
            new Order($mongo, $jms),
            $jms,
            $container->get('validator')
        );
    }
}
