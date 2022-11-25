<?php

declare(strict_types=1);

use Slim\Csrf\Guard;
use Twig\Extension\AbstractExtension;
use Twig\Extension\GlobalsInterface;


class CsrfExtension extends AbstractExtension implements GlobalsInterface
{
    protected Guard $csrf;

    public function __construct(Guard $csrf)
    {
        $this->csrf = $csrf;
    }

    public function getGlobals(): array
    {
        $csrfNameKey = $this->csrf->getTokenNameKey();
        $csrfValueKey = $this->csrf->getTokenValueKey();
        $csrfName = $this->csrf->getTokenName();
        $csrfValue = $this->csrf->getTokenValue();

        return [
            'csrf' => [
                'keys' => [
                    'name' => $csrfNameKey,
                    'value' => $csrfValueKey
                ],
                'name' => $csrfName,
                'value' => $csrfValue
            ]
        ];
    }
}