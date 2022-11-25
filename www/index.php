<?php

declare(strict_types=1);

use Slim\App;

require __DIR__ . '/../vendor/autoload.php';

session_set_cookie_params(0, '', '', true, true);
session_start();
session_regenerate_id();

$builder = new DI\ContainerBuilder();
$dependencies = require __DIR__ . '/../app/dependencies.php';
$dependencies($builder);
$container = $builder->build();
$app = $container->get(App::class);
$middleware = require __DIR__ . '/../app/middleware.php';
$middleware($app);
$routes = require __DIR__ . '/../app/routes.php';
$routes($app);
$app->run();