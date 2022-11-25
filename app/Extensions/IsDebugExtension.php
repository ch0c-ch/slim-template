<?php

declare(strict_types=1);

use Slim\Csrf\Guard;
use Twig\Environment;
use Twig\Extension\AbstractExtension;
use Twig\Extension\GlobalsInterface;


class IsDebugExtension extends AbstractExtension implements GlobalsInterface
{
    protected Environment $environment;

    public function __construct(Environment $environment)
    {
        $this->environment = $environment;
    }

    public function getGlobals(): array
    {
        return [
            'isDebug' => $this->environment->isDebug()
        ];
    }
}