<?php

declare(strict_types=1);

use DI\Bridge\Slim\Bridge;
use DI\ContainerBuilder;
use Psr\Container\ContainerInterface;
use Slim\App;
use Slim\Csrf\Guard;
use Slim\Flash\Messages;
use Slim\HttpCache\CacheProvider;
use Slim\Psr7\Factory\ResponseFactory;
use Slim\Views\Twig;

require __DIR__ . '/Extensions/CsrfExtension.php';
require __DIR__ . '/Extensions/BasePathExtension.php';
require __DIR__ . '/Extensions/IsDebugExtension.php';

return function (ContainerBuilder $builder) {
    $builder->addDefinitions([
        App::class => function (ContainerInterface $container) {
            return Bridge::create($container);
        },
        ResponseFactory::class => function (App $app) {
            return $app->getResponseFactory();
        },
        Twig::class => function (App $app, Guard $guard) {
            $twig = Twig::create(__DIR__ . '/../views', ['cache' => false, 'debug' => true]);
            $twig->addExtension(new CsrfExtension($guard));
            $twig->addExtension(new BasePathExtension($app));
            $twig->addExtension(new IsDebugExtension($twig->getEnvironment()));
            return $twig;
        },
        Guard::class => function (ResponseFactory $responseFactory) {
            $guard = new Guard($responseFactory);
            $guard->setPersistentTokenMode(true);
            return $guard;
        },
        CacheProvider::class => function () {
            return new CacheProvider();
        },
        Messages::class => function () {
            $storage = [];
            return new Messages($storage);
        }
    ]);
};