<?php

declare(strict_types=1);

namespace App;

/**
 * The configuration provider for the App module
 *
 * @see https://docs.zendframework.com/zend-component-installer/
 */
class ConfigProvider
{
    /**
     * Returns the configuration array
     *
     * To add a bit of a structure, each section is defined in a separate
     * method which returns an array with its configuration.
     *
     */
    public function __invoke() : array
    {
        return [
            'dependencies' => $this->getDependencies(),
            'templates'    => $this->getTemplates(),
        ];
    }

    /**
     * Returns the container dependencies
     */
    public function getDependencies() : array
    {
        return [
            'factories'  => [
                \App\Products\Post::class => \App\Products\Factory\Post::class,
                \App\Products\GetAll::class => \App\Products\Factory\GetAll::class,
                \App\Customers\Post::class => \App\Customers\Factory\Post::class,
                \App\Order\Post::class => \App\Order\Factory\Post::class,
                \App\Order\GetAll::class => \App\Order\Factory\GetAll::class,
                \App\Order\Put::class => \App\Order\Factory\Put::class,
                \App\Populate\Populate::class => \App\Populate\Factory\Populate::class
            ],
        ];
    }

    /**
     * Returns the templates configuration
     */
    public function getTemplates() : array
    {
        return [
            'paths' => [
                'app'    => [__DIR__ . '/../templates/app'],
                'error'  => [__DIR__ . '/../templates/error'],
                'layout' => [__DIR__ . '/../templates/layout'],
            ],
        ];
    }
}
