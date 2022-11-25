<?php

declare(strict_types=1);

use Slim\App;
use Twig\Extension\AbstractExtension;
use Twig\Extension\GlobalsInterface;

class BasePathExtension extends AbstractExtension implements GlobalsInterface
{
    protected App $app;

    public function __construct(App $app)
    {
        $this->app = $app;
    }

    public function getGlobals(): array
    {
        return [
            'base_path' => $this->app->getBasePath()
        ];
    }
}