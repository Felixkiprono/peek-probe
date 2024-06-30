<?php

use function Peek\Probe\Peek;

it('tests-peek', function () {

    $cars = ["brand" => "Honda", "model" => "CRV", "YOM" => 2005, "cc" => 2000];
    $result = Peek($cars);
    expect($result)->toBe(true);
});
