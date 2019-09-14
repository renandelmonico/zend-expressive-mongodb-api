<?php
/**
 * @author Renan Delmonico <renandelmonico@gmail.com>
 */

declare(strict_types=1);

namespace App\Container;

use Psr\Container\ContainerInterface;
use JMS\Serializer\SerializerBuilder;
use JMS\Serializer\Serializer;
use JMS\Serializer\Naming\IdenticalPropertyNamingStrategy;
use JMS\Serializer\SerializationContext;

/**
 * Factory do serializador JMS
 */
class JMSFactory
{
    public function __invoke(ContainerInterface $container):Serializer
    {
        return SerializerBuilder::create()
            ->setPropertyNamingStrategy(new IdenticalPropertyNamingStrategy)
            ->setSerializationContextFactory(function () {
                return SerializationContext::create()->setSerializeNull(true);
            })
            ->build();
    }
}
