<?php

namespace Peek\Probe;

use Peek\Probe\Settings\Configuration;
use Peek\Probe\Probe;

function Peek($args): bool
{
    $configurations = new Configuration([]);
    $probe = new Probe($configurations);
    $probe->peek($args);
    return true;
}
