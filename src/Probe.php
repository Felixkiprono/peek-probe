<?php

namespace Peek\Probe;

use Peek\Probe\Settings\Configuration;
use Peek\Probe\Socket\Client;

class Probe
{

    public $configurations;

    public function __construct(Configuration $configurations)
    {
        $this->configurations = $configurations;
    }

    public function isEnabled()
    {
        return $this->configurations->_get('enable') ? $this->configurations->_get('enable') : false;
    }

    public function peek($data)
    {
        if ($this->isEnabled()) {
            $client = new Client($this->configurations);
            $client->sendRequest($data);
        }
    }
}
