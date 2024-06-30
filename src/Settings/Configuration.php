<?php

namespace Peek\Probe\Settings;

use Arr;

class Configuration
{
    protected $settings = [];
    protected $defaultConfigs = [
        'enable' => true,
        'host' => 'localhost',
        'port' => 9008
    ];

    public function __construct(array $customConfig)
    {
        if ($customConfig) {
            $this->settings = $customConfig;
        }
        if (empty($this->getConfigurationsFromFile())) {
            $this->settings = $this->defaultConfigs;
        }
        if ($this->getConfigurationsFromFile()) {
            $this->settings = $this->getConfigurationsFromFile();
        }
    }


    public function _get($key)
    {
        return $this->settings[$key] ?? null;
    }


    public function _set($key, $value)
    {
        return $this->settings[$key] = $value;
    }

    public function getConfigurationsFromFile(): array
    {
        return [];
    }
}
