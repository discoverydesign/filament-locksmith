<?php

namespace DiscoveryDesign\FilamentLocksmith\Generators;

class BaseGenerator
{
    public string $name = 'Base';
    private array $options = [];

    public function getOptions(): array
    {
        return $this->options;
    }

    public function setOptions(array $options)
    {
        $this->options = $options;

        return $this;
    }

    public function generate($get)
    {
        return 'password';
    }
}
