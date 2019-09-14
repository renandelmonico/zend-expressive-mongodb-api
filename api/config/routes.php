<?php

declare(strict_types=1);

use Psr\Container\ContainerInterface;
use Zend\Expressive\Application;
use Zend\Expressive\MiddlewareFactory;

/**
 * Setup routes with a single request method:
 *
 * $app->get('/', App\Handler\HomePageHandler::class, 'home');
 * $app->post('/album', App\Handler\AlbumCreateHandler::class, 'album.create');
 * $app->put('/album/:id', App\Handler\AlbumUpdateHandler::class, 'album.put');
 * $app->patch('/album/:id', App\Handler\AlbumUpdateHandler::class, 'album.patch');
 * $app->delete('/album/:id', App\Handler\AlbumDeleteHandler::class, 'album.delete');
 *
 * Or with multiple request methods:
 *
 * $app->route('/contact', App\Handler\ContactHandler::class, ['GET', 'POST', ...], 'contact');
 */
return function (Application $app, MiddlewareFactory $factory, ContainerInterface $container) : void {
    $app->post(
        '/v1/products',
        [
            /*new App\Middleware\Token(
                $container->get('config')['jwt']['key'],
                $container->get('config')['jwt']['algorithm']
            ),*/
            App\Products\Post::class
        ],
        'products.insert'
    );
    $app->get(
        '/v1/products',
        [
            App\Products\GetAll::class
        ],
        'products.list'
    );
    $app->post(
        '/v1/customers',
        [
            App\Customers\Post::class
        ],
        'customers.insert'
    );
    $app->post(
        '/v1/orders',
        [
            App\Order\Post::class
        ],
        'orders.insert'
    );
    $app->get(
        '/v1/orders',
        [
            App\Order\GetAll::class
        ],
        'orders.list'
    );
    $app->put(
        '/v1/orders/{idorder}',
        [
            App\Order\Put::class
        ],
        'orders.put'
    );
    $app->get(
        '/v1/populate',
        [
            App\Populate\Populate::class
        ],
        'populate'
    );
};
