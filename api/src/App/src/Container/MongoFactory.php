<?php
/**
 * @author Renan Delmonico <renandelmonico@gmail.com>
 */

declare(strict_types=1);

namespace App\Container;

use Psr\Container\ContainerInterface;
use MongoDB\Database;

/**
 * Factory da conexao com o mongodb
 */
class MongoFactory
{
    public function __invoke(ContainerInterface $container):Database
    {
        $config = $container->get('config')['mongo'];

        $Mongo = new \MongoDB\Client(sprintf(
            'mongodb://%s:%s@%s:%s',
            $config['username'],
            $config['password'],
            $config['ip'],
            $config['port']
        ));
        return $Mongo->selectDatabase($config['database']);
    }
}
