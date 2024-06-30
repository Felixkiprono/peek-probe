<?php
use function Peek\Probe\Peek;

it('tests-peek', function () {
    $result = Peek("php 8.2" );
    expect($result)->toBe(true);
});
