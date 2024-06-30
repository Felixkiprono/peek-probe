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

    /**
     * __construct
     *
     * @param  mixed $customConfig
     * @return void
     */
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


    /**
     * _get
     *
     * @param  mixed $key
     * @return void
     */
    public function _get($key)
    {
        return $this->settings[$key] ?? null;
    }


    /**
     * _set
     *
     * @param  mixed $key
     * @param  mixed $value
     * @return void
     */
    public function _set($key, $value)
    {
        return $this->settings[$key] = $value;
    }

    /**
     * getConfigurationsFromFile
     *
     * @return array
     */
    public function getConfigurationsFromFile(): array
    {
        return [];
    }
}
