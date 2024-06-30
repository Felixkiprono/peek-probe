<?php

namespace Peek\Probe;

use Peek\Probe\Settings\Configuration;
use Peek\Probe\Socket\Client;

class Probe
{

    public $configurations;

    /**
     * __construct
     *
     * @param  mixed $configurations
     * @return void
     */
    public function __construct(Configuration $configurations)
    {
        $this->configurations = $configurations;
    }

    /**
     * isEnabled
     *
     * @return void
     */
    public function isEnabled()
    {
        return $this->configurations->_get('enable') ? $this->configurations->_get('enable') : false;
    }

    /**
     * peek
     *
     * @param  mixed $data
     * @return void
     */
    public function peek($data)
    {
        if ($this->isEnabled()) {
            $client = new Client($this->configurations);
            $client->sendRequest($data);
        }
    }
}
