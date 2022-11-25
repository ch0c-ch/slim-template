<?php

declare(strict_types=1);

use Psr\Http\Server\RequestHandlerInterface;
use Slim\App;
use Slim\Csrf\Guard;
use Slim\Flash\Messages;
use Slim\Middleware\ErrorMiddleware;
use Slim\Psr7\Request;
use Slim\Views\Twig;
use Slim\Views\TwigMiddleware;

return function (App $app) {
    $callableResolver = $app->getCallableResolver();
    $responseFactory = $app->getResponseFactory();
    $app->add(TwigMiddleware::createFromContainer($app, Twig::class));
    $app->add(new ErrorMiddleware($callableResolver, $responseFactory, true, true, true));
    $app->add(Guard::class);
    $app->add(function (Request $request, RequestHandlerInterface $next) {
        $this->get(Messages::class)->__construct($_SESSION);
        return $next->handle($request);
    });
};